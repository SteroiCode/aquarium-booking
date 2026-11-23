# Bakong KHQR Integration Setup

## Prerequisites

### 1. Get Bakong Merchant Account
You need to register as a merchant with National Bank of Cambodia:
- Website: https://www.nbc.gov.kh/
- Or contact: Bakong Support Team
- Get your credentials:
  - Merchant ID
  - API Key
  - API Secret

### 2. Required Information
- Business Name
- Business Registration
- Bank Account
- Contact Information

## Installation Steps

### Step 1: Install Bakong SDK
```bash
composer require bakong/khqr
```

### Step 2: Add to .env
```env
BAKONG_MERCHANT_ID=your_merchant_id
BAKONG_API_KEY=your_api_key
BAKONG_API_SECRET=your_api_secret
BAKONG_ENVIRONMENT=sandbox  # or 'production'
```

### Step 3: Configure
Add to `config/services.php`:
```php
'bakong' => [
    'merchant_id' => env('BAKONG_MERCHANT_ID'),
    'api_key' => env('BAKONG_API_KEY'),
    'api_secret' => env('BAKONG_API_SECRET'),
    'environment' => env('BAKONG_ENVIRONMENT', 'sandbox'),
],
```

## Testing

### Sandbox Mode
- Use test credentials from Bakong
- Test payments without real money
- Perfect for development

### Production Mode
- Use real merchant credentials
- Real payments processed
- Goes to your bank account

## Important Notes

1. **Merchant Registration**: Takes 1-2 weeks
2. **Bank Account**: Must be Cambodian bank
3. **Business License**: Required for production
4. **Transaction Fees**: Usually 0% for KHQR

## For University Project

If you don't have merchant account yet, I can implement:
- Mock payment system (simulates Bakong)
- Works exactly like real integration
- Perfect for demonstration
- Can switch to real API later

Let me know if you have Bakong credentials or want mock version!
