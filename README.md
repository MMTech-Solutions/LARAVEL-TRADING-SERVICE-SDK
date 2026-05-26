# mmt/laravel-trading-service-sdk

Cliente PHP (**SDK**) para Laravel que integra aplicaciones con el **MMT Trading Service**: operaciones de administración de brokers y de plataformas de trading (MT5, B2Trader y futuras) mediante una API tipada, sin acoplar el dominio de la aplicación a detalles HTTP.

**Versión estable:** `2.0.0.0` (etiqueta Git `v2.0.0.0`). Release anterior: `v1.2.1.0`.

> **⚠ Breaking changes en v2.0.0.0** — Ver sección [Migración desde v1.x](#migración-desde-v1x).

## Propósito

- Centralizar URLs, verbos HTTP y forma de las peticiones respecto al contrato del servicio remoto.
- Exponer **comandos** (`CommandInterface` + DTOs con `toArray()`) y un **resultado de acción** uniforme (`ActionResultInterface`), materializado en HTTP por `ResponseResult`, alineado con el envelope JSON del API.
- Integrarse en **Laravel** mediante service provider, configuración y contenedor de inyección de dependencias.
- Soportar múltiples plataformas de trading desde la misma sesión: `$session->mt5()`, `$session->b2t()`.

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

## Uso rápido

### 1. Conexión y sesión (`BrokerSession`)

El punto de entrada es `TradingService`. Tras conectar el broker obtienes una sesión que encapsula el `connection_id` y expone la API por plataforma (`mt5()`, `b2t()`).

Cada plataforma tiene su propio comando de conexión que implementa `ConnectCommandInterface`:

**MT5:**

```php
use Mmt\TradingServiceSdk\Platforms\TradingService;
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\MT5ConnectCommand;
use Mmt\TradingServiceSdk\Enums\PlatformEnum;

$trading = app(TradingService::class);

$session = $trading->connect(
    new MT5ConnectCommand(
        server: 'broker.example.com',
        port: 443,
        platform_type: PlatformEnum::MT5,
        login: 'manager_login',
        password: 'secret',
        name: 'Mi broker MT5',
    ),
    $connectionId // opcional: recibe el id creado por referencia
);

$mt5 = $session->mt5();
$result = $mt5->listGroups();
```

**B2Trader:**

```php
use Mmt\TradingServiceSdk\Platforms\B2Trader\Commands\B2TConnectCommand;
use Mmt\TradingServiceSdk\Enums\PlatformEnum;

$session = $trading->connect(
    new B2TConnectCommand(
        server: 'b2t.example.com',
        port: 443,
        platform_type: PlatformEnum::B2T,
        login: 'manager_login',
        password: 'secret',
        name: 'Mi broker B2T',
    ),
    $connectionId
);

$b2t = $session->b2t();
$result = $b2t->getServerTime();
```

Para reutilizar una conexión ya conocida (persistida en BD, caché, etc.):

```php
$session = $trading->fromConnectionId($connectionIdGuardado);

$mt5 = $session->mt5();
$b2t = $session->b2t();
```

### 2. Resultado de transporte (`ActionResultInterface` / `ResponseResult`)

`TransportInterface::send()` devuelve `ActionResultInterface`. La implementación HTTP concreta es `Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http\ResponseResult`, construida con:

- `fromSuccessResponse(string $rawJson)` — parsea el envelope de éxito (`code`, `message`, `data`).
- `fromErrorResponse(string $rawJson)` — parsea errores (incluye `detail` en `getErrorDetails()` cuando exista).

Métodos habituales: `isSuccess()`, `getCode()`, `getMessage()`, `getData(?string $castToFqcn = null)`, `getErrorDetails()`, `getRawResponse()`.

**Cast opcional de `data`:** si pasas un FQCN de clase con constructor promovido cuyos nombres de parámetro coinciden con las claves de cada elemento del JSON, `getData(EsaClase::class)` devuelve una instancia; si `data` es una lista homogénea, devuelve un array de instancias.

```php
if ($result->isSuccess()) {
    $raw   = $result->getData();                  // array asociativo / lista
    $typed = $result->getData(SomeDTO::class);    // instancia o array de instancias
}
```

### 3. Inyección directa de plataforma

Puedes resolver cualquier interfaz de plataforma directamente si ya conoces el `connectionId`:

```php
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;
use Mmt\TradingServiceSdk\Platforms\B2Trader\Contracts\B2TTradingServiceInterface;

$mt5 = resolve(MT5TradingServiceInterface::class, ['connectionId' => $connectionId]);
$b2t = resolve(B2TTradingServiceInterface::class, ['connectionId' => $connectionId]);
```

El provider registra ambas implementaciones con **`bind`**, no singleton, para que cada resolución pueda llevar su propio `connectionId`.

## Buenas prácticas con `connection_id`

- Obtén una conexión nueva (`connect` / flujo admin equivalente) **solo cuando** corresponda (alta de broker, rotación de credenciales, etc.), no en cada petición HTTP de tu app.
- **Persiste** el `connection_id` (y lo que exija tu integración, p. ej. `broker_key`) y reutilízalo hasta que el servicio invalide la sesión.

La forma devuelta al conectar está descrita en `Platforms\Shared\ObjectResponses\BrokerConnectionResponse`.

## Arquitectura

| Capa | Rol |
|------|-----|
| **`TradingService`** | Conexión al broker y fábrica de `BrokerSession` / `fromConnectionId`. Acepta cualquier `ConnectCommandInterface`. |
| **`BrokerSession` / `BrokerSessionInterface`** | Mantiene `connectionId` y delega en `mt5()` y `b2t()`. |
| **`MT5TradingService` + `MT5TradingServiceInterface`** | Contrato y rutas bajo `/v1/mt5/connections/{connectionId}/…`. |
| **`B2TTradingService` + `B2TTradingServiceInterface`** | Contrato y rutas bajo `/v1/b2t/connections/{connectionId}/…`. |
| **Comandos** (`Contracts/CommandInterface`, `Platforms/*/Commands`) | Entrada serializable vía `toArray()`. Los comandos de conexión implementan también `ConnectCommandInterface`. |
| **Transporte** (`TransportInterface`, `TransportPacket`, `TradingServiceHttpClient`) | Aísla método, endpoint, query serializada y timeouts opcionales en metadata del paquete. |
| **`ActionResultInterface`** | Contrato del resultado; **`ResponseResult`** (HTTP) es la implementación por defecto. |

## Plataformas soportadas

### MT5

La lista autoritativa de operaciones disponibles es **`MT5TradingServiceInterface`**: símbolos, grupos, usuarios, posiciones (abrir / modificar / cerrar / cerrar todas), deals, órdenes, márgenes, transacciones, precios, etc.

- Comandos: `src/Platforms/MT5/Commands/`
- Respuestas: `src/Platforms/MT5/ObjectResponses/`
- Enums: `src/Platforms/MT5/Enums/`
- Conexión: `MT5ConnectCommand`

### B2Trader

La lista autoritativa de operaciones disponibles es **`B2TTradingServiceInterface`**: usuarios, perfiles, cuentas, márgenes, posiciones, órdenes, deals, transferencias, símbolos, ticks, grupos, perfiles de apalancamiento, roles, etc.

- Comandos: `src/Platforms/B2Trader/Commands/`
- DTOs (entidades de dominio): `src/Platforms/B2Trader/DTOs/`
- ObjectResponses (envoltorios de operación): `src/Platforms/B2Trader/ObjectResponses/`
- Enums: `src/Platforms/B2Trader/Enums/`
- Conexión: `B2TConnectCommand`

**Convención B2Trader — DTOs vs ObjectResponses:**

| Carpeta | Contenido |
|---|---|
| `DTOs/` | Entidades de dominio reutilizables: `Account`, `AccountState`, `Asset`, `BulkClosedPosition`, `ClosedPosition`, `DealInfo`, `GroupInfo`, `LeverageProfile`, `MarginLevel`, `Order`, `Position`, `RoleInfo`, `SymbolInfo`, `TickInfo`, `TransactionHistoryItem`, `UserAccessData`, `UserProfile` |
| `ObjectResponses/` | Envoltorios de operación específicos (siempre con sufijo `Response`): `OpenPositionResponse`, `ClosePositionResponse`, `CloseAllPositionsResponse`, `ClosedPositionsResponse`, `GroupsResponse`, `AccountGroupResponse`, `AccountsByLoginResponse`, `AddBalanceResponse`, `SetBalanceResponse`, `ServerTimeResponse` |

## Estructura del código (resumen)

```
src/
├── Contracts/                    # CommandInterface, ConnectCommandInterface
├── Enums/                        # PlatformEnum (MT5, B2T), LanguagesEnum, …
├── Exceptions/
├── Session/                      # BrokerSession, BrokerSessionInterface
├── Platforms/
│   ├── TradingService.php
│   ├── Shared/                   # BrokerConnectionResponse
│   ├── MT5/                      # Contrato, servicio, Commands, ObjectResponses, Enums
│   └── B2Trader/                 # Contrato, servicio, Commands, DTOs, ObjectResponses, Enums
├── TransportDrivers/
│   ├── Contracts/                # TransportInterface, TransportPacket, ActionResultInterface
│   ├── Drivers/Http/             # TradingServiceHttpClient, ResponseResult
│   └── Traits/                   # WithHttpClient
└── TradingServiceSdkServiceProvider.php
```

## Migración desde v1.x

### `ConnectBrokerCommand` eliminado

`ConnectBrokerCommand` (`Platforms\Shared\Commands\ConnectBrokerCommand`) ha sido eliminado. Reemplázalo por el comando específico de la plataforma:

```php
// Antes (v1.x)
use Mmt\TradingServiceSdk\Platforms\Shared\Commands\ConnectBrokerCommand;
$trading->connect(new ConnectBrokerCommand(...));

// Ahora (v2.x) — MT5
use Mmt\TradingServiceSdk\Platforms\MT5\Commands\MT5ConnectCommand;
$trading->connect(new MT5ConnectCommand(...));

// Ahora (v2.x) — B2Trader
use Mmt\TradingServiceSdk\Platforms\B2Trader\Commands\B2TConnectCommand;
$trading->connect(new B2TConnectCommand(...));
```

### `TradingService::connect()` — tipo de parámetro

El parámetro pasó de `ConnectBrokerCommand` (clase concreta) a `ConnectCommandInterface`. Ambos comandos nuevos implementan esa interfaz, por lo que el cambio es transparente si usas los nuevos comandos.

### `BrokerSessionInterface` — nuevo método `b2t()`

Si implementas `BrokerSessionInterface` fuera del SDK (p. ej. en tests), debes añadir el método:

```php
public function b2t(): B2TTradingServiceInterface;
```

## Versionado

Este repositorio usa etiquetas Git para releases públicas:

| Etiqueta | Notas breves |
|------------|----------------|
| `v1.0.0.0` | Base estable: sesión, MT5 vía interfaz, `ActionResult` / `ResponseResult` HTTP. |
| `v1.1.0.0` | Menor: `openPosition`, `LanguagesEnum` en usuarios, `getData(FQCN)` con mapeo a DTOs. |
| `v1.2.1.0` | Menor: ajustes en MT5, `BrokerConnectionResponse` con campo `platform`. |
| `v2.0.0.0` | **Breaking:** soporte B2Trader, `ConnectCommandInterface`, comandos de conexión por plataforma (`MT5ConnectCommand`, `B2TConnectCommand`), `BrokerSession::b2t()`, `PlatformEnum::B2T`. Eliminado `ConnectBrokerCommand`. |

En la aplicación consumidora fija la dependencia a la etiqueta concreta (p. ej. `2.0.0.0`) o al criterio semver que uses internamente.

## Licencia

MIT (ver `composer.json`).
