
### Project Design Documentation – CP3407

This document describes the architectural, database, and user interface designs for our project. All components were planned to meet the user requirements and ensure smooth interaction between frontend, backend, and database systems.

---

## Architectural Design

We used a **simple MVC-style structure** in PHP for separating logic, UI, and data interaction.

- **Frontend**: HTML, CSS (Bootstrap for responsiveness)
- **Backend**: PHP for server-side logic
- **Database**: MySQL for storing user, service, and booking information
- **Hosting**: InfinityFree for web deployment

### UML Diagram

A high-level architectural diagram was created using [Gliffy UML Tool](https://www.gliffy.com/uses/uml-software):

📎 [UML Design Diagram (link or screenshot placeholder)]

---

## Database Design

We used **phpMyAdmin on InfinityFree** to create and manage our MySQL database. The database includes the following main tables:

| Table Name   | Description                          |
|--------------|--------------------------------------|
| `users`      | Stores user login info and roles     |
| `salons`     | Contains salon profiles and details  |
| `services`   | Lists available beauty services      |
| `bookings`   | Stores customer bookings             |
| `messages`   | (Optional) Customer-salon messages   |

### Relationships

- Each user can have **one role**: either Customer or Salon
- Customers can make **multiple bookings**
- Each salon offers **multiple services**

📎 [Database Diagram using GenMyModel](https://www.genmymodel.com/database-diagram-online)

---

## User Interface Design

We created UI wireframes using [NinjaMock](https://ninjamock.com/) to plan the layout and flow.

### Pages

| Page Name         | Description                                           |
|-------------------|-------------------------------------------------------|
| Home              | Welcome page with navigation to services              |
| Login/Register    | Separate login and registration forms for each user  |
| User Dashboards   | Two types: Customer Dashboard and Salon Dashboard     |
| Services          | Browsable list with filtering/searching               |
| Bookings          | View, create, cancel bookings                         |
| Contact/About     | Static pages with contact form                        |

### UI Considerations

- Mobile-friendly design using Bootstrap
- Separate dashboards depending on login type
- Intuitive navigation and quick access to actions

📎 [Interface Mockups (link to image or NinjaMock export)]

---

## Design Summary

Our design ensures:

- Clear separation of user types and responsibilities
- Scalable database structure for storing user and service data
- Responsive UI with basic usability and navigation principles
- Code organization that supports future features (e.g. payments, notifications)

