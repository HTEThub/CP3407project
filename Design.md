
### Project Design Documentation – CP3407

This document describes the architectural, database, and user interface designs for our project. All components were planned to meet the user requirements and ensure smooth interaction between frontend, backend, and database systems.

---

## 🏛️ Architectural Design

We implemented a lightweight MVC-style structure using PHP to maintain separation of concerns between presentation, logic, and data layers.

- **Frontend:** HTML and CSS (Bootstrap framework used for responsiveness and consistency)
- **Backend:** PHP handles routing, form processing, and business logic
- **Database:** MySQL is used to store users, bookings, services, and other core data
- **Hosting:** All components are hosted on [InfinityFree](https://infinityfree.net), which provides:
  - PHP web server
  - MySQL database hosting
  - Free file and domain hosting for deployment

## 📦 UML Diagram

The following UML diagram represents the high-level architecture of the GlamUp system, illustrating how components interact:
![Architecture_UML drawio](https://github.com/user-attachments/assets/68302055-fbd2-4f54-b6b3-f643649c9fbe)


---

## Database Design

We used **phpMyAdmin on InfinityFree** to create and manage our MySQL database. The database includes the following main tables:

| Table Name   | Description                                                    |
|--------------|----------------------------------------------------------------|
| `users`      | Stores user login, phone, location, pyament info and roles     |
| `bookings`   | Stores customer bookings                                       |
| `messages`   | (Optional) Customer-salon messages                             |


### Relationships

- Each user can have **one role**: either Customer or Artist
- Customers can make **multiple bookings**
- Artist can see **all created bookings**

<img width="464" alt="Screenshot 2025-04-19 at 9 47 39 PM" src="https://github.com/user-attachments/assets/08981182-22cd-4fa0-90cc-170a6e4670b6" />

---

## User Interface Design

We created UI wireframes using drawings to plan the layout and flow.

### Pages

| Page Name         | Description                                           |
|-------------------|-------------------------------------------------------|
| Home              | Welcome page with navigation to services              |
| Services          | Browsable list with filtering/searching               |
| Booking           | Customers can create bookings                         |
| Booking List      | Artists can view and accept, finish or cancel bookings|
| Contact           | Static pages with contact form                        |
| Profile/Edit      | Page full of user's information that can be edited    |
| Login/Register    | Separate login and registration forms for each user   |

### UI Considerations
- Separate Booking Pages depending on login type (Customer = Booking, Artist = Booking List)
- Intuitive navigation and quick access to actions

📎 [Interface Mockups (link to image or NinjaMock export)]
![20250419_224305](https://github.com/user-attachments/assets/0b1770e6-4016-485c-959a-b259990ff5e7)

![20250419_224320](https://github.com/user-attachments/assets/347cfbeb-8429-4a81-918b-0b25c4953210)

![20250419_224334](https://github.com/user-attachments/assets/363cc726-098c-4180-9054-907c5c2b0d60)

---

## Design Summary

Our design ensures:
- Separation of user types and responsibilities
- Scalable database structure for storing user data
- Responsive UI with basic usability and navigation principles

