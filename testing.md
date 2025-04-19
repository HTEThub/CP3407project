### Project Testing Documentation – CP3407

This document outlines the testing strategies and processes used to ensure the quality and functionality of the project.

---

### Testing Overview

We used a combination of manual and functional testing to ensure that the main components of our website work as intended. These include:

- **Frontend UI Testing**
- **Backend PHP Logic Testing**
- **Database Interaction Testing**
- **Form Validation**
- **User Type Behaviour Testing** (Customer vs Salon)

---

### Testing Types and Examples

| Test Type | Description | Outcome |
|-----------|-------------|---------|
| **User Interface (UI) Testing** | Checked layout, buttons, and responsiveness of all pages on mobile and desktop | ✅ Passed |
| **Form Validation** | Ensured that required fields are validated (e.g. contact form, login, registration) | ✅ Passed |
| **Login/Logout Tests** | Verified correct login/logout flow for both users | ✅ Passed |
| **Dashboard Behaviour** | Tested the two types of dashboards (Customer & Salon) for correct visibility and permissions | ✅ Passed |
| **Database Testing** | Ensured proper insertion, updating, and fetching of user data and bookings using PHP/MySQL | ✅ Passed |
| **Error Handling** | Simulated errors (e.g. incorrect password, empty form fields) | ✅ Error messages shown correctly |
| **Email Notifications (if implemented)** | Tested triggering of confirmation or alert emails | ✅/❌ (based on implementation) |

---

### Manual Testing

All features were manually tested after development:

- Login/logout with real user credentials
- Registering new users
- Making and cancelling bookings
- Filtering services
- Database entries created and retrieved as expected

---

### Testing Data

We used sample test data to simulate:

- Registered users with different roles
- Services and salon data
- Bookings and interactions

Test data was entered directly through forms and/or phpMyAdmin.

---

### Acceptance Testing

We validated that:

- All planned user stories were implemented
- Functional flows like registration, login, booking, and profile editing worked correctly
- The website performs well on both desktop and mobile browsers

---

### Summary

All essential parts of the system were thoroughly tested, with a focus on user experience, correct logic handling, and reliable database performance.
