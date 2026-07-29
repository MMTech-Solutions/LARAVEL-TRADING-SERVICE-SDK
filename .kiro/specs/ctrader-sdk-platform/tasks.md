# Tasks: CTrader Platform — Laravel Trading Service SDK

## Task List

- [x] 1. Add CT case to PlatformEnum
  - Add `CT = 3` to `src/Enums/PlatformEnum.php`
  - Map `'ct'` and `'ctrader'` in `tryFromString()`
  - Requirement: 1.6

- [x] 2. Create TransactionTypeEnum
  - Create `src/Platforms/CTrader/Enums/TransactionTypeEnum.php`
  - Backed string enum: `Deposit = 'deposit'`, `Withdrawal = 'withdrawal'`
  - Requirement: 6.1

- [x] 3. Create CTraderConnectCommand
  - Create `src/Platforms/CTrader/Commands/CTraderConnectCommand.php`
  - Implements `ConnectCommandInterface`
  - All fields per design.md ConnectCtraderBody schema
  - `platformSlug()` returns `'ctrader'`
  - `toArray()` filters nulls
  - Requirements: 1.1–1.5

- [x] 4. Create user-related Commands
  - [x] 4a. `src/Platforms/CTrader/Commands/CreateUserCommand.php`
  - [x] 4b. `src/Platforms/CTrader/Commands/UpdateUserCommand.php`
  - [x] 4c. `src/Platforms/CTrader/Commands/ChangePasswordCommand.php`
  - [x] 4d. `src/Platforms/CTrader/Commands/CheckPasswordCommand.php`
  - [x] 4e. `src/Platforms/CTrader/Commands/SetUserAccessCommand.php`
  - All implement `CommandInterface`, filter nulls in `toArray()`
  - Requirements: 4.1–4.4

- [x] 5. Create transaction Commands
  - [x] 5a. `src/Platforms/CTrader/Commands/TransactionCommand.php` (with TransactionTypeEnum)
  - Requirements: 4.1–4.4

- [x] 6. Create trading/position Commands
  - [x] 6a. `src/Platforms/CTrader/Commands/OpenPositionCommand.php`
  - [x] 6b. `src/Platforms/CTrader/Commands/ClosePositionCommand.php`
  - [x] 6c. `src/Platforms/CTrader/Commands/CloseAllPositionsCommand.php`
  - [x] 6d. `src/Platforms/CTrader/Commands/ModifyPositionCommand.php`
  - [x] 6e. `src/Platforms/CTrader/Commands/GetClosedPositionsCommand.php`
  - [x] 6f. `src/Platforms/CTrader/Commands/CancelAllOpenOrdersCommand.php`
  - [x] 6g. `src/Platforms/CTrader/Commands/CloseAllTradingCommand.php`
  - Requirements: 4.1–4.4

- [x] 7. Create history/query Commands
  - [x] 7a. `src/Platforms/CTrader/Commands/GetDealsHistoryCommand.php`
  - [x] 7b. `src/Platforms/CTrader/Commands/GetOrdersCommand.php`
  - [x] 7c. `src/Platforms/CTrader/Commands/GetOrdersByTicketsCommand.php`
  - [x] 7d. `src/Platforms/CTrader/Commands/GetPriceHistoryCommand.php` (with `$name` path field)
  - Requirements: 4.1–4.4

- [x] 8. Create DTOs
  - Create all 16 DTOs in `src/Platforms/CTrader/DTOs/` per design.md table
  - All `final readonly` classes, all fields nullable
  - Requirements: 5.1–5.3

- [-] 9. Create CTraderTradingServiceInterface
  - Create `src/Platforms/CTrader/Contracts/CTraderTradingServiceInterface.php`
  - Declare all 42 methods with correct signatures and PHPDoc
  - Requirements: 2.1–2.4

- [ ] 10. Create CTraderTradingService
  - Create `src/Platforms/CTrader/Contracts/CTraderTradingService.php`
  - Uses `WithHttpClient` trait, sets base URL in constructor
  - Implements all 42 methods with `#[Override]`
  - Timeout constants for long-running operations
  - Requirements: 3.1–3.6

- [~] 11. Register CTrader in ServiceProvider
  - Add `CTraderTradingServiceInterface` → `CTraderTradingService` binding in `TradingServiceSdkServiceProvider::register()`
  - Requirements: 7.1–7.2

- [~] 12. Commit, tag, and push to Packagist
  - Stage all new/modified files
  - Commit: `feat(ctrader): add CTrader platform support`
  - Tag `v3.2.0.0`
  - Push branch and tag to origin
  - Requirements: 8.1–8.3
