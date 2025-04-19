# GlamUp Project – Testing Overview

This document explains the testing strategy used in the GlamUp online beauty booking system.

## What We Tested

| Component        | Test File           | Description |
|------------------|---------------------|-------------|
| Registration     | tests/RegisterTest.php | Tests all inputs, password hashing, artist fields, resume upload |
| Login            | tests/LoginTest.php    | Tests email/password reading, hashing, login redirect |
| Logout           | tests/LogoutTest.php   | Tests session clearing and redirect logic |
| Profile View/Update | tests/ProfileTest.php | Tests user display, session detection, edit submission |
| Booking Flow     | tests/BookingTest.php  | Tests booking date/time, session logic |
| Artist Bookings  | tests/BookingListTest.php | Tests artist-only view, status updates |
| Edit Profile     | tests/EditProfileTest.php | Tests data update, optional password, email conflict |

## Test Strategy

- Unit tested all logic-heavy PHP pages
- Simulated POST, GET, FILES, SESSION
- Validated security (passwords, XSS, sessions)
- Checked UI messages and redirect behavior

## Tools

- **PHPUnit 12.1.2**
- **PHP 8.4.6**
- Manual testing via browser
- XAMPP local server

## Outcome

- 22 tests covering all business logic
- 39 assertions total
- 100% pass rate with no critical warnings or failures

