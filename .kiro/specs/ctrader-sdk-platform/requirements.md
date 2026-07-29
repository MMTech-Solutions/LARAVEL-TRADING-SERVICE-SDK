# Requirements: CTrader Platform — Laravel Trading Service SDK

## Introduction

The `mmt/laravel-trading-service-sdk` currently supports MT5 and B2Trader. CTrader brokers are in use by the platform but have no SDK support, meaning callers must manage raw HTTP themselves. This feature adds CTrader as a first-class platform.

## Requirements

### 1. CTrader Connect Command

**User Story:** As a consumer of the SDK, I want to connect to a CTrader broker using a typed command so that I can obtain a `connection_id` for subsequent trading operations.

#### Acceptance Criteria
- 1.1 `CTraderConnectCommand` implements `ConnectCommandInterface`
- 1.2 Required constructor fields: `server` (string), `port` (int), `login` (string), `password` (string)
- 1.3 Optional constructor fields: `name`, `broker_name`, poll interval floats, manager proxy fields (all nullable)
- 1.4 `platformSlug()` returns `'ctrader'`
- 1.5 `toArray()` excludes null values; body matches `ConnectCtraderBody` schema
- 1.6 `PlatformEnum` gains `CT = 3`; `tryFromString` maps `'ct'` and `'ctrader'`

### 2. CTrader Service Interface

**User Story:** As a consumer, I want a typed interface for all CTrader trading operations so that my IDE can autocomplete and static analysis can validate my code.

#### Acceptance Criteria
- 2.1 `CTraderTradingServiceInterface` declares all 42 methods mapped from the OpenAPI spec
- 2.2 Every method returns `ActionResultInterface`
- 2.3 Methods requiring a command accept `CommandInterface` (not a concrete type in the interface signature)
- 2.4 PHPDoc `@param` and `@return` tags specify the expected command class and response DTO

### 3. CTrader Service Implementation

**User Story:** As a consumer, I want a concrete service that routes calls to the correct HTTP endpoints so that I don't need to construct URLs or payloads manually.

#### Acceptance Criteria
- 3.1 `CTraderTradingService` implements `CTraderTradingServiceInterface`
- 3.2 Uses `WithHttpClient` trait; sets base URL `/v1/ctrader/connections/{connectionId}` in constructor
- 3.3 Long-running methods use appropriate timeouts (open/close positions ≥ 70 s, close-all ≥ 125 s)
- 3.4 Path segments are URL-encoded via `encodePathSegment()`
- 3.5 All methods are annotated with `#[Override]`
- 3.6 Invalid command type passed to a method that requires a specific command throws `InvalidArgumentException`

### 4. Commands

**User Story:** As a consumer, I want typed command objects for each CTrader write/query operation so that payloads are validated at construction time.

#### Acceptance Criteria
- 4.1 All commands implement `CommandInterface`
- 4.2 `toArray()` filters null values from output
- 4.3 Commands with path-segment fields (e.g. `GetPriceHistoryCommand::$name`) expose them as public properties
- 4.4 Required fields are non-nullable constructor parameters; optional fields are nullable with `= null`

### 5. DTOs

**User Story:** As a consumer, I want typed response DTOs so that I can hydrate API responses into strongly typed objects.

#### Acceptance Criteria
- 5.1 All 16 DTOs are `final readonly` classes
- 5.2 All DTO fields are nullable (API responses may omit fields)
- 5.3 DTOs are placed in `src/Platforms/CTrader/DTOs/`

### 6. Enums

**User Story:** As a consumer, I want enums for CTrader-specific fields so that I use valid values.

#### Acceptance Criteria
- 6.1 `TransactionTypeEnum` is a backed string enum with `Deposit` and `Withdrawal` cases

### 7. Service Provider Registration

**User Story:** As a Laravel application consumer, I want the CTrader service to be resolvable from the container so that I can inject `CTraderTradingServiceInterface` without manual wiring.

#### Acceptance Criteria
- 7.1 `TradingServiceSdkServiceProvider` binds `CTraderTradingServiceInterface` to `CTraderTradingService`
- 7.2 The binding uses `bind()` (not `singleton()`) consistent with MT5 and B2Trader

### 8. Release

**User Story:** As a PropFirm developer, I want the new version available on Packagist so that I can update the dependency with `composer require mmt/laravel-trading-service-sdk:^3.2`.

#### Acceptance Criteria
- 8.1 Changes are committed to `main` with message `feat(ctrader): add CTrader platform support`
- 8.2 Tag `v3.2.0.0` is created and pushed to origin
- 8.3 Packagist webhook fires automatically upon push
