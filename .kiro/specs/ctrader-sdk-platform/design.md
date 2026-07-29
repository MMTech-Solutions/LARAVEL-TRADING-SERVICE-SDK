# Design: CTrader Platform — Laravel Trading Service SDK

## Overview

Add CTrader as a first-class platform in `mmt/laravel-trading-service-sdk`, following the exact same structure and philosophy as the existing MT5 and B2Trader platforms. The result is tagged as `v3.2.0.0` and pushed to Packagist.

**Source of truth:** `docs/references/Ctrader/openapi.json` in MMT-PropFirm.  
**Base URL pattern:** `/v1/ctrader/connections/{connection_id}/...`  
**Platform slug for connect:** `ctrader`

---

## Directory Structure

```
src/Platforms/CTrader/
├── Commands/
│   ├── CTraderConnectCommand.php
│   ├── CreateUserCommand.php
│   ├── UpdateUserCommand.php
│   ├── ChangePasswordCommand.php
│   ├── CheckPasswordCommand.php
│   ├── SetUserAccessCommand.php
│   ├── TransactionCommand.php
│   ├── OpenPositionCommand.php
│   ├── ClosePositionCommand.php
│   ├── CloseAllPositionsCommand.php
│   ├── ModifyPositionCommand.php
│   ├── GetClosedPositionsCommand.php
│   ├── GetDealsHistoryCommand.php
│   ├── GetOrdersCommand.php
│   ├── GetOrdersByTicketsCommand.php
│   ├── GetPriceHistoryCommand.php
│   └── CancelAllOpenOrdersCommand.php
├── Contracts/
│   ├── CTraderTradingServiceInterface.php
│   └── CTraderTradingService.php
├── DTOs/
│   ├── UserData.php
│   ├── AccountStateData.php
│   ├── MarginLevelData.php
│   ├── SymbolData.php
│   ├── GroupData.php
│   ├── HierarchyGroupData.php
│   ├── PositionData.php
│   ├── ClosedPositionData.php
│   ├── DealData.php
│   ├── OrderData.php
│   ├── TransactionData.php
│   ├── ExecutePositionData.php
│   ├── ClosePositionData.php
│   ├── PriceData.php
│   ├── PriceHistoryData.php
│   └── CheckPasswordData.php
└── Enums/
    └── TransactionTypeEnum.php
```

Also modified:
- `src/Enums/PlatformEnum.php` — add `CT = 3` case
- `src/TradingServiceSdkServiceProvider.php` — bind `CTraderTradingServiceInterface`
- `composer.json` — no change needed (autoload covers `src/` recursively)

---

## PlatformEnum Change

```php
enum PlatformEnum: int
{
    case MT5 = 1;
    case B2T = 2;
    case CT  = 3;          // new

    public static function tryFromString(string $platform): self
    {
        return match(strtolower($platform)) {
            'mt5'     => self::MT5,
            'b2t'     => self::B2T,
            'ct', 'ctrader' => self::CT,   // new
            default   => throw new PlatformNotSupportedException(),
        };
    }
    // ... rest unchanged
}
```

---

## Connect Command

`CTraderConnectCommand` implements `ConnectCommandInterface`.

| Field | Type | Required | Notes |
|-------|------|----------|-------|
| `server` | string | ✓ | Host, IP, or full URL |
| `port` | int | ✓ | Ignored when server is full URL |
| `login` | string | ✓ | Admin/API login |
| `password` | string | ✓ | Admin/API password |
| `name` | ?string | — | Optional label |
| `broker_name` | ?string | — | Spotware broker/white-label name |
| `open_positions_poll_interval_sec` | ?float | — | StreamEvents poll interval |
| `closed_positions_poll_interval_sec` | ?float | — | StreamEvents poll interval |
| `margin_poll_interval_sec` | ?float | — | StreamEvents poll interval |
| `manager_proxy_host` | ?string | — | Hybrid Manager API |
| `manager_proxy_port` | ?int | — | Manager Proxy port |
| `manager_plant_id` | ?string | — | Spotware plantId |
| `manager_environment_name` | ?string | — | e.g. demo or live |
| `manager_verify_tls` | ?bool | — | Verify TLS cert |
| `manager_server_hostname` | ?string | — | SNI / cert hostname |
| `manager_ca_file` | ?string | — | CA file path |

`platformSlug()` returns `'ctrader'`.  
`toArray()` filters `null` values.

---

## Service Interface — `CTraderTradingServiceInterface`

All methods return `ActionResultInterface`. Grouped by domain:

### Server
| Method | HTTP | Path |
|--------|------|------|
| `getServerTime()` | GET | `/server-time` |

### Users
| Method | HTTP | Path |
|--------|------|------|
| `listUsers(?string $groupFilter)` | GET | `/users` |
| `getUser(string $login)` | GET | `/users/{login}` |
| `createUser(CommandInterface $command)` | POST | `/users` |
| `updateUser(CommandInterface $command)` | PATCH | `/users` |
| `getAccountState(string $login)` | GET | `/users/{login}/account-state` |
| `setUserAccess(CommandInterface $command)` | POST | `/users/access` |
| `changePassword(CommandInterface $command)` | POST | `/users/change-password` |
| `checkPassword(CommandInterface $command)` | POST | `/users/check-password` |
| `getMarginLevel(string $login)` | GET | `/users/{login}/margin` |
| `getMarginLevels(CommandInterface $command)` | GET | `/users/margins` |
| `getMarginLevelsByOpenPositions()` | GET | `/users/margins-by-open-positions` |

### Transactions
| Method | HTTP | Path |
|--------|------|------|
| `changeBalance(CommandInterface $command)` | POST | `/transactions/change` |
| `setBalance(CommandInterface $command)` | POST | `/transactions/set` |

### Groups
| Method | HTTP | Path |
|--------|------|------|
| `listGroups()` | GET | `/groups` |
| `getGroupHierarchy()` | GET | `/groups/hierarchy` |
| `getGroup(string $name)` | GET | `/groups/{name}` |

### Symbols
| Method | HTTP | Path |
|--------|------|------|
| `listSymbols(?string $groupFilter)` | GET | `/symbols` |
| `getSymbol(string $name)` | GET | `/symbols/{name}` |
| `getSymbolCategories()` | GET | `/symbol-categories` |
| `getLastPrice(string $name)` | GET | `/symbols/{name}/last-price` |
| `getPriceAt(string $name, int $timestamp)` | GET | `/symbols/{name}/price-at` |
| `getPriceHistory(CommandInterface $command)` | GET | `/symbols/{name}/price-history` |

### Positions
| Method | HTTP | Path |
|--------|------|------|
| `getAllPositions()` | GET | `/positions/all` |
| `getPositions(string $login)` | GET | `/positions` |
| `getPosition(string $entityId)` | GET | `/positions/{entity_id}` |
| `openPosition(CommandInterface $command)` | POST | `/positions/execute` |
| `modifyPosition(CommandInterface $command)` | PATCH | `/positions` |
| `closePosition(CommandInterface $command)` | POST | `/positions/close` |
| `closeAllPositions(CommandInterface $command)` | POST | `/positions/close-all` |
| `getClosedPositions(?CommandInterface $command)` | GET | `/positions/closed` |

### Deals
| Method | HTTP | Path |
|--------|------|------|
| `getDeal(string $dealId)` | GET | `/deals/{deal_id}` |
| `getOpenDeal(string $positionId)` | GET | `/deals/open/{position_id}` |
| `getCloseDeal(string $positionId)` | GET | `/deals/close/{position_id}` |
| `getAllDealsForPosition(string $positionId)` | GET | `/deals/position/{position_id}` |
| `getDealsHistory(CommandInterface $command)` | GET | `/deals/history` |

### Orders
| Method | HTTP | Path |
|--------|------|------|
| `getOrder(string $orderId)` | GET | `/orders/{order_id}` |
| `getOrders(CommandInterface $command)` | GET | `/orders` |
| `getOrdersByTickets(CommandInterface $command)` | GET | `/orders/by-tickets` |
| `cancelAllOpenOrders(CommandInterface $command)` | POST | `/orders/cancel-all` |

### Trading
| Method | HTTP | Path |
|--------|------|------|
| `closeAllTrading(CommandInterface $command)` | POST | `/trading/close-all` |

---

## Service Implementation — `CTraderTradingService`

- Implements `CTraderTradingServiceInterface`
- Uses `WithHttpClient` trait (same as B2Trader)
- Constructor: `__construct(private readonly string $connectionId)`
- Sets base URL in constructor: `/v1/ctrader/connections/{connectionId}`
- Timeout constants mirror MT5: `TIMEOUT_EXECUTE_POSITION = 70.0`, `TIMEOUT_CLOSE_ALL_POSITIONS = 125.0`, `TIMEOUT_GET_POSITIONS = 35.0`
- All methods use `#[Override]`

---

## Commands

### `CreateUserCommand`
Fields: `password` (req), `group` (req), `email` (req), `leverage` (req, int), `login` (?string), `agent_account` (?string), `password_investor` (?string), `first_name` (?string), `last_name` (?string), `company` (?string), `language` (?string), `country` (?string), `city` (?string), `state` (?string), `zip_code` (?string), `address` (?string), `phone` (?string), `comment` (?string), `deposit_currency` (?string), `access_rights` (?string)

### `UpdateUserCommand`
Fields: `login` (req, string), `group` (?string), `name` (?string), `email` (?string), `leverage` (?int), `first_name` (?string), `last_name` (?string), `company` (?string), `language` (?string), `country` (?string), `city` (?string), `state` (?string), `zip_code` (?string), `address` (?string), `phone` (?string), `comment` (?string), `access_rights` (?string)

### `ChangePasswordCommand`
Fields: `login` (req), `new_password` (req), `is_investor` (?bool)

### `CheckPasswordCommand`
Fields: `login` (req), `password` (req), `is_investor` (?bool)

### `SetUserAccessCommand`
Fields: `login` (req), `access` (req)

### `TransactionCommand`
Fields: `login` (req), `amount` (req, float), `comment` (?string), `type` (?TransactionTypeEnum)

### `OpenPositionCommand`
Fields: `login` (req), `symbol` (req), `volume` (req, float), `command` (?string — buy/sell), `sl` (?float), `tp` (?float), `comment` (?string)

### `ClosePositionCommand`
Fields: `position_id` (req), `volume` (?float), `comment` (?string)

### `CloseAllPositionsCommand` (= `CloseAllBody`)
Fields: `login` (req), `symbol_filter` (?string), `comment` (?string)

### `ModifyPositionCommand`
Fields: `position_id` (req), `sl` (?float), `tp` (?float)

### `CancelAllOpenOrdersCommand`
Fields: `login` (req)

### `GetClosedPositionsCommand`
Fields: `login` (?string), `closed_from` (?string), `closed_to` (?string)

### `GetDealsHistoryCommand`
Fields: `login` (req), `from_timestamp` (?int), `to_timestamp` (?int)

### `GetOrdersCommand`
Fields: `login` (req), `from_timestamp` (?int), `to_timestamp` (?int)

### `GetOrdersByTicketsCommand`
Fields: `order_ids` (req, string[])

### `GetPriceHistoryCommand`
Fields: `name` (req — used in path), `from_ts` (req, int), `to_ts` (req, int), `limit` (?int)

### `CloseAllTradingCommand` (= `CloseAllTradingBody`)
Fields: `login` (req), `symbol_filter` (?string), `comment` (?string)

---

## DTOs (ObjectResponses)

All use `readonly` constructor properties, all nullable-safe.

| Class | Fields |
|-------|--------|
| `UserData` | `login, group, name, first_name, last_name, company, language, country, city, state, zip_code, address, phone, email, comment, leverage` |
| `AccountStateData` | `login, access` |
| `MarginLevelData` | `login, balance, credit, equity, margin, margin_free, margin_level, leverage, currency_digits` |
| `SymbolData` | `name, path, description, volume_min, contract_size, volume_step, digits` |
| `GroupData` | `name, enabled, currency, margin_call, symbols_group, id` |
| `HierarchyGroupData` | `name, enabled, currency, categories` |
| `PositionData` | `id, login, symbol, volume, open_price, current_price, sl, tp, swap, profit, comment, time` |
| `ClosedPositionData` | `position_id, order_id, deal_id` |
| `DealData` | `id, login, order_id, position_id, symbol, volume, price, profit, time, type, entry` |
| `OrderData` | `id, login, symbol, volume, price, time, type, state` |
| `TransactionData` | `ticket, new_balance` |
| `ExecutePositionData` | `order_id, login, symbol, action, user_id, order_index` |
| `ClosePositionData` | `order_id, price, volume, deal_id, position_id` |
| `PriceData` | `symbol, bid, ask, last, timestamp` |
| `PriceHistoryData` | `symbol, points` |
| `CheckPasswordData` | `password_correct` |

---

## Enums

### `TransactionTypeEnum`
```php
enum TransactionTypeEnum: string
{
    case Deposit    = 'deposit';
    case Withdrawal = 'withdrawal';
}
```

---

## ServiceProvider Binding

```php
// Added to TradingServiceSdkServiceProvider::register()
$this->app->bind(CTraderTradingServiceInterface::class, CTraderTradingService::class);
```

---

## Versioning & Git

- Tag: `v3.2.0.0`
- Commit message: `feat(ctrader): add CTrader platform support`
- Push tag to origin (triggers Packagist webhook)
- No changes to `composer.json` version field (Packagist uses git tags)
