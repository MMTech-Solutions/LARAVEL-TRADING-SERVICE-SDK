# mmt/laravel-trading-service-sdk

Cliente PHP (**SDK**) para Laravel que integra aplicaciones con el **MMT Trading Service**: operaciones de administración de brokers y de plataformas de trading (MT5 y futuras) mediante una API tipada, sin acoplar el dominio de la aplicación a detalles HTTP.

**Versión estable:** `1.0.0.0` (etiqueta Git `v1.0.0.0`).

## Propósito

- Centralizar URLs, verbos HTTP y forma de las peticiones respecto al contrato del servicio remoto.
- Exponer **comandos** (`CommandInterface` + DTOs con `toArray()`) y un **resultado de acción** uniforme (`ActionResultInterface`), materializado en HTTP por `ResponseResult`, alineado con el envelope JSON del API.
- Integrarse en **Laravel** mediante service provider, configuración y contenedor de inyección de dependencias.

## Requisitos

- PHP `^8.3`
- [Guzzle](https://github.com/guzzle/guzzle) `^7.2` (transporte HTTP por defecto)
- Laravel con carga del paquete vía `composer.json` → `extra.laravel.providers` (descubrimiento automático)

## Instalación

```bash
composer require mmt/laravel-trading-service-sdk
```

Publicar configuración (opcional):

```bash
php artisan vendor:publish --tag=laravel-trading-service-sdk-config
```

Variables y clave de configuración:

| Uso | Valor |
|-----|--------|
| Variable de entorno | `TRADING_SERVICE_URL` — URL base del Trading Service |
| Archivo de config | `config/laravel-trading-service-sdk.php` |
| Clave en runtime | `config('laravel-trading-service-sdk.base_url')` |

Si publicaste antes un archivo con otro nombre, vuelve a publicar con el tag anterior o alinea el nombre con `laravel-trading-service-sdk.php`.

## Uso rápido

### 1. Conexión y sesión (`BrokerSession`)

El punto de entrada es `TradingService`. Tras conectar el broker obtienes una sesión que encapsula el `connection_id` y expone la API por plataforma (`mt5()`).

```php
use Mmt\TradingServiceSdk\Platforms\TradingService;
use Mmt\TradingServiceSdk\Platforms\Shared\Commands\ConnectBrokerCommand;
use Mmt\TradingServiceSdk\Enums\PlatformEnum;

$trading = app(TradingService::class);

$session = $trading->connect(
    new ConnectBrokerCommand(
        server: 'broker.example.com',
        port: 443,
        platform_type: PlatformEnum::MT5,
        login: 'manager_login',
        password: 'secret',
        name: 'Mi broker',
        keycloak_url: null,
        bbp_client_id: null,
        bbp_client_secret: null,
    ),
    $connectionId // opcional: referencia al id creado
);

$mt5 = $session->mt5();
$result = $mt5->listGroups();

if ($result->isSuccess()) {
    $data = $result->getData(); // object|array según payload del API
}
```

Para reutilizar una conexión ya conocida (persistida en BD, caché, etc.):

```php
$session = $trading->fromConnectionId($connectionIdGuardado);
$mt5 = $session->mt5();
```

### 2. Resultado de transporte (`ActionResultInterface` / `ResponseResult`)

`TransportInterface::send()` devuelve `ActionResultInterface`. La implementación HTTP concreta es `Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http\ResponseResult`, construida con:

- `fromSuccessResponse(string $rawJson)` — parsea el envelope de éxito (`code`, `message`, `data`).
- `fromErrorResponse(string $rawJson)` — parsea errores (incluye `detail` en `getErrorDetails()` cuando exista).

Métodos habituales: `isSuccess()`, `getCode()`, `getMessage()`, `getData()`, `getErrorDetails()`, `getRawResponse()`.

Los métodos de `MT5TradingServiceInterface` declaran en PHPDoc el tipo esperado de `getData()` cuando el contrato del API es estable (p. ej. listados, DTOs en `Platforms/MT5/ObjectResponses/`).

### 3. Inyección directa de MT5

Puedes resolver `MT5TradingServiceInterface` con el parámetro de contenedor `connectionId` (p. ej. en tests o jobs que ya conocen el id):

```php
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;

$mt5 = resolve(MT5TradingServiceInterface::class, ['connectionId' => $connectionId]);
```

El provider registra la implementación con **`bind`**, no singleton, para que cada resolución pueda llevar su propio `connectionId`.

## Buenas prácticas con `connection_id`

- Obtén una conexión nueva (`connect` / flujo admin equivalente) **solo cuando** corresponda (alta de broker, rotación de credenciales, etc.), no en cada petición HTTP de tu app.
- **Persiste** el `connection_id` (y lo que exija tu integración, p. ej. `broker_key`) y reutilízalo hasta que el servicio invalide la sesión.

La forma devuelta al conectar está descrita en `Platforms\Shared\ObjectResponses\BrokerConnectionResponse` (campos según contrato del API).

## Arquitectura

| Capa | Rol |
|------|-----|
| **`TradingService`** | Conexión al broker y fábrica de `BrokerSession` / `fromConnectionId`. |
| **`BrokerSession` / `BrokerSessionInterface`** | Mantiene `connectionId` y delega en `mt5()` (y futuras plataformas). |
| **`MT5TradingService` + `MT5TradingServiceInterface`** | Contrato y rutas bajo `/v1/mt5/connections/{connectionId}/…`. |
| **Comandos** (`Contracts/CommandInterface`, `Platforms/*/Commands`) | Entrada serializable vía `toArray()`. |
| **Transporte** (`TransportInterface`, `TransportPacket`, `TradingServiceHttpClient`) | Aísla método, endpoint, query serializada y timeouts opcionales en metadata del paquete. |
| **`ActionResultInterface`** | Contrato del resultado; **`ResponseResult`** (HTTP) es la implementación por defecto. |

## Superficie MT5 y otros módulos

La lista autoritativa de operaciones MT5 disponibles en esta versión es **`MT5TradingServiceInterface`**: símbolos, grupos, usuarios, posiciones, deals, órdenes, márgenes, transacciones, precios, etc. Los comandos viven en `src/Platforms/MT5/Commands/`; respuestas y enums en `ObjectResponses/` y `Enums/`.

## Estructura del código (resumen)

```
src/
├── Contracts/                    # CommandInterface
├── Enums/                        # p. ej. PlatformEnum
├── Exceptions/
├── Session/                      # BrokerSession, BrokerSessionInterface
├── Platforms/
│   ├── TradingService.php
│   ├── Shared/                   # ConnectBrokerCommand, BrokerConnectionResponse
│   └── MT5/                      # Contrato, servicio, Commands, ObjectResponses, Enums
├── TransportDrivers/
│   ├── Contracts/                # TransportInterface, TransportPacket, ActionResultInterface
│   └── Drivers/Http/             # TradingServiceHttpClient, ResponseResult
└── TradingServiceSdkServiceProvider.php
```

## Versionado

Este repositorio usa etiquetas Git para releases públicas. La primera línea estable publicada es **`v1.0.0.0`**. En `composer.json` de la aplicación consumidora puedes fijar la dependencia a esa etiqueta o al rango que definas en tu política interna.

## Licencia

MIT (ver `composer.json`).
