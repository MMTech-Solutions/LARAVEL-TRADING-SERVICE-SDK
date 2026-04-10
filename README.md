# mmt/laravel-trading-service-sdk

Cliente PHP (**SDK**) para Laravel que integra aplicaciones con el **MMT Trading Service**: expone operaciones de administración de brokers y de plataformas de trading (p. ej. MT5) mediante una API tipada, sin acoplar el código de negocio a detalles HTTP.

## Propósito

- Centralizar URLs, verbos y formas de petición/respecto al contrato del servicio remoto.
- Ofrecer **comandos** (DTOs) serializables y **resultados** uniformes (`ResponseResult`) alineados con el envelope JSON del API.
- Integrarse en aplicaciones **Laravel** vía service provider, configuración y contenedor de inyección de dependencias.

## Estado actual

Este paquete está en **construcción activa**.

- La **arquitectura base** (transporte, fachada por plataforma, registro en Laravel) está definida y en uso.
- Los **métodos expuestos** cubren un subconjunto inicial del Trading Service; **el resto de endpoints y operaciones se irán añadiendo de forma incremental**. Hasta entonces, conviene revisar la interfaz concreta (`MT5TradingServiceInterface`, etc.) como fuente de verdad de lo ya soportado.
- Pueden existir comandos u objetos de respuesta preparados para evolucionar el API antes de que el método correspondiente quede expuesto en la interfaz pública.

## Requisitos

- PHP `^8.3`
- [Guzzle](https://github.com/guzzle/guzzle) `^7.2` (cliente HTTP del transporte por defecto)
- Proyecto **Laravel** que cargue el service provider (descubrimiento automático vía `composer.json` → `extra.laravel.providers`)

## Instalación

En un monorepo o aplicación que ya referencia el paquete por path/repositorio:

```bash
composer require mmt/laravel-trading-service-sdk
```

Publicar configuración (opcional, para sobreescribir valores por entorno):

```bash
php artisan vendor:publish --tag=laravel-trading-service-sdk-config
```

Variable de entorno habitual: `TRADING_SERVICE_URL` (URL base del servicio; ver `config/laravel-trading-service-sdk.php`).

Si ya publicaste la config con el nombre anterior (`trading-service-sdk`), renombra el archivo y la clave a `laravel-trading-service-sdk` o vuelve a publicar con el tag nuevo.

## Uso orientativo

El punto de entrada recomendado es `TradingService`: agrupa lo **transversal** (p. ej. conexión de broker) y delega en sub-APIs por plataforma mediante métodos explícitos (`mt5()`, y en el futuro otros como `cTrader()`).

```php
use Mmt\TradingServiceSdk\Platforms\TradingService;
use Mmt\TradingServiceSdk\Platforms\Shared\Commands\ConnectBrokerCommand;

// Resolución típica en Laravel (singleton registrado en el provider)
$trading = app(TradingService::class);

$result = $trading->createConnectionId(new ConnectBrokerCommand(/* ... */));

if ($result->isSuccess()) {
    $data = $result->getData(); // estructura devuelta por el API (tipado en PHPDoc donde aplique)
}

$mt5 = $trading->mt5();
// $mt5->listSymbols($connectionId, $optionalCommand);
```

Para operaciones MT5 también puedes inyectar `Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface` directamente en tus clases si prefieres no pasar por la fachada.

### `connectionId` y uso de `createConnectionId`

El método `createConnectionId` (conexión de broker vía `ConnectBrokerCommand`) sirve para **obtener una sola vez** el identificador que el Trading Service asigna a una **conexión lógica ya establecida** hacia el broker (credenciales, servidor, plataforma validados en el servicio remoto). Ese valor (`connection_id` en la respuesta, ver `BrokerConnectionResponse`) es el que debes pasar en las rutas MT5 y operaciones posteriores (`/v1/mt5/connections/{connectionId}/…`).

**Práctica recomendada por el servicio de terceros y por el diseño del SDK:**

- Llama a `createConnectionId` **solo cuando haga falta** (alta de broker, rotación de credenciales, cambio de servidor, etc.), **no en cada petición HTTP** de tu aplicación.
- **Persiste** el `connection_id` (y, si el contrato del API lo exige en tu integración, el `broker_key`) en el mecanismo que elijas: base de datos, caché, configuración de tenant, etc.
- **Reutiliza** ese identificador en todas las llamadas siguientes, **en el mismo request o en otros**, hasta que el servicio invalide la conexión o cambie el contexto del broker.

El proveedor **desaconseja un uso desmedido** de la creación de conexiones: cada llamada puede implicar coste (autenticación, recursos en el gateway, límites operativos). El `connectionId` actúa como **referencia estable** para decir “usa la sesión/contexto de este broker ya registrado”, sin repetir el trabajo de apertura.

## Arquitectura e intención

### Capas

| Capa | Rol |
|------|-----|
| **`TradingService`** (`Platforms/TradingService`) | Fachada de entrada: operaciones que no pertenecen a una sola plataforma y **acceso nominal a cada plataforma** (`mt5()`, …). Evita un único servicio monolítico y reduce `if/else` o factories opacos para el consumidor. |
| **API por plataforma** (p. ej. `MT5TradingService` + `MT5TradingServiceInterface`) | Contrato y rutas bajo un prefijo coherente (`/v1/mt5/connections/{id}/…`). Cada plataforma puede crecer sin mezclar métodos con otras. |
| **Comandos** (`Contracts/CommandInterface`, `Platforms/.../Commands`) | Entrada tipada hacia el JSON/query del API mediante `toArray()`. |
| **Transporte** (`TransportInterface`, `TransportPacket`, implementación HTTP con Guzzle) | Aísla método, endpoint y cuerpo; permite sustituir o testear el canal sin tocar la lógica MT5/admin. |
| **`ResponseResult`** | Resultado homogéneo (éxito/error, código, mensaje, `data`) acorde al envelope del servicio remoto. |

### Estrategia adoptada

1. **Un solo punto de entrada legible** — El consumidor entiende de inmediato si usa capacidades “globales” o una plataforma concreta (`->mt5()`), sin depender de nombres genéricos o ramas manuales.
2. **Inyección de dependencias** — `TradingService` recibe `TransportInterface` y `MT5TradingServiceInterface` por constructor; el contenedor Laravel resuelve singletons compartidos. Se priorizan métodos explícitos frente a propiedades mágicas para autocompletado y análisis estático.
3. **Extensibilidad** — Nuevas plataformas o transportes se añaden como implementaciones e interfaces, manteniendo la fachada como mapa claro del SDK.

## Estructura del código (resumen)

```
src/
├── Contracts/                 # CommandInterface
├── Exceptions/
├── Platforms/
│   ├── TradingService.php     # Fachada
│   ├── Shared/                # Comandos/responses compartidos (p. ej. conexión broker)
│   └── MT5/                   # Contrato, implementación, comandos y DTOs de respuesta MT5
├── TransportDrivers/
│   ├── Contracts/
│   └── Drivers/Http/
└── TradingServiceSdkServiceProvider.php
```

## Licencia

MIT (ver `composer.json`).
