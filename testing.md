# 📦 GlamUp Project – Testing Overview

This document explains the testing strategy used in the GlamUp online beauty booking system.

---

## ✅ What We Tested

| Component           | Test File                   | Description |
|---------------------|-----------------------------|-------------|
| Registration        | tests/RegisterTest.php      | Tests all inputs, password hashing, artist checkbox, resume upload |
| Login               | tests/LoginTest.php         | Tests email/password reading, password verification, redirect |
| Logout              | tests/LogoutTest.php        | Tests session clearing and redirect logic |
| Profile View/Update | tests/ProfileTest.php       | Tests session presence, user info rendering, form field values |
| Booking Flow        | tests/BookingTest.php       | Tests booking datetime format, POST logic, session state |
| Artist Bookings     | tests/BookingListTest.php   | Tests artist access, booking status update POST logic |
| Edit Profile        | tests/EditProfileTest.php   | Tests optional password updates, email conflict, update logic |

---

## 🧪 Test Strategy

- ✅ Unit tested all PHP files containing core application logic
- ✅ Simulated `$_POST`, `$_GET`, `$_FILES`, and `$_SESSION` variables
- ✅ Validated security (password hashing, input escaping, session handling)
- ✅ Verified conditional logic paths, user roles, and form behaviors
- ✅ Avoided testing view rendering; focused on business logic

---

## 🧰 Tools Used

- **PHPUnit 12.1.2**
- **PHP 8.4.6**
- **macOS + XAMPP local server**
- Manual browser testing for UI behavior

---

## ✅ Testing Outcome

- ✅ **35 test cases written**
- ✅ **60 total assertions**
- ✅ **All tests passed successfully**
- ✅ Only minor warnings (no critical issues)
- ✅ No test failures or errors

---

## 📌 Summary

This test suite provides strong confidence in the logic and flow of the GlamUp project. Each major feature was tested in isolation, using realistic data and edge cases. Logic was validated through assertions, and security measures such as password hashing and session logic were also covered.
