# QA Test Checklist - Quick Testing Guide

## Pre-Testing Setup

- [✅] Plugin installed and activated
- [✅] Navigate to Settings → QA Test
- [✅] Form loads correctly

## Form Display Tests

- [✅] All 8 fields visible
- [❌] Required fields show red asterisks (Full Name, Nickname, Email)
  - Nickname shows as Required but is not
  - Address does NOT show Required but it is
  - Email Address shows as Required but is not
- [❌] Month dropdown has all 12 months
  - Missing October
- [✅] Form styling looks correct

## Field Validation Tests

### Full Name Field

- [✅] Test: "Sergio Rivera" (valid) - Should PASS
- [✅] Test: "Sergio E. Rivera" (valid) - Should PASS
- [✅] Test: "Sergio 1978 Rivera" (numbers) - Should FAIL
- [✅] Test: "Sergio-Rivera" (special chars) - Should FAIL
- [✅] Test: "" (empty) - Should FAIL
- [❌] Test: "Sergio !@#%^&\* Rivera" (extra special chars) - Should FAIL
  - The regexp `'/[$\-_\[\]{}\+,]/'` at line 187 allows a lot of special chars, this must be changed to `'/^[a-zA-Z\s\.]+$/'` since we only allow letters and dots.

### Email Field

- [✅] Test: "me@company.com" (valid) - Should PASS
- [✅] Test: "mecompany.com" (invalid) - Should FAIL
- [❌] Test: "" (empty) - Should FAIL (Is shown as Required)

### Website Field

- [✅] Test: "https://sergiorivera.me" (valid) - Should PASS
- [✅] Test: "sergiorivera.me" (invalid) - Should FAIL (Missing protocol)
- [✅] Test: "" (empty) - Should PASS

### Address Field

- [❌] Test: "" (empty) - Should PASS
  - Marked as NOT Required but when submiting we show a message as required field
- [✅] Test: "123 Main Street" (valid) - Should PASS

### Nickname Field

- [❌] Test: "" (empty) - Should FAIL (marked required)
  - When submitting we are not validating if its required
- [✅] Test: "Pepe El toro" (valid) - Should PASS

### Date of Birth

- [✅] Test Day: "29" (valid) - Should PASS
- [❌] Test Day: "35" (invalid) - Should FAIL
- [✅] Test Month: "December" (valid) - Should PASS
- [❌] Test Month: "October" - Should FAIL not present
- [✅] Test Year: "1978" (valid) - Should PASS
- [✅] Test Year: "1965" (below 1970) - Should FAIL
  - Wrong error message says `Date of Birth Year must be between 1900 and 2017` message to display should be `betweem 1965 and 2017`
- [✅] Test Year: "2020" (above 2017) - Should FAIL
- [✅] Leap year: Day: 29, Month: February, Year: 2000 - Should PASS
- [❌] Leap year: Day: 29, Month: February, Year: 2001 - Should FAIL
  - There is no Leap year validation

## Data Persistence Tests

- [✅] Fill all fields with valid data and save
- [❌] Refresh page - check if data persists
  - `Nickname` and `Website` are not persisted after submitting

## Error Message Tests

- [✅] Submit form with invalid data
- [✅] Check if error messages appear
- [❌] Check if error messages are clear and helpful
  - Date of birth is showing 1900 instead of 1965
  - Nickname is not showing a message when submitting even if its Required
  - Must add red \* to state that Address is Required
  - Email Address is not showing a message when submitting even if its Required

## Quick Issues to Look For (WIP)

- [❌] **CRITICAL:** October missing from month dropdown
- [❌] **CRITICAL:** Website field not saving
- [❌] **MEDIUM:** Address field validation inconsistency
- [❌] **MEDIUM:** Nickname field no validation despite being required
- [❌] **MEDIUM:** Year validation logic issues example: not validating leap Years.
