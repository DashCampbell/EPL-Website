# Edmonton Public Library PHP Emulation
I made a copy of the Edmonton Public Library website from scratch. The front end is made up of html, css, jquery. The backend is built using php and MySQL. My copy only emulates some pages of the website. User authentication, responsive web design, and the use of databases are all part of the emulation.

## Getting Started
* I used XAMPP to run the code, but an equivalent may also work.
### Setting up the database
1. In phpMyAdmin(for XAMPP), create a new database named 'epl'

1. Inside the database create a new table called 'epl_account' with the following columns:
    Column Name | Column Type
    -----|-----
    Name | text
    Full Name | text
    Phone Number | text
    Email | text
    username | text
    password | text
    checked_items | text
    hold_items | text
    Fines | int(11)
    due_dates | text

1. Create a new table called 'epl_item' with the following columns:
    Column Name | Column Type
    -----|-----
    Title | text
    Author | text
    Format | enum('Videogame', 'Audiobook', 'Movie', 'Music', 'eBook', 'Book')
    Content | enum('Fiction', 'Nonfiction')
    Subject | enum('Art & Literature', 'Biography', 'Finance', 'Research')
    Age | enum('Kids 1-6', 'Kids 6-12', 'Teen', 'Adult')
    Published Date | date
    Cover_URL | text
    Copies | int(11)
    Holds | int(11)

### Running the website
1. Run UPDATE_ITEMS&CLIENTS.php, to add library items and card holders to the database.
1. Open homepage.php to see the website.

## Pages Copied
* Home page
* Login page
* Search/Browse items page
* Create new account page
* Change user email/username/password/phone number pages
* Pages showing the user's holds, fees, and checked out items.

## Showcase
https://github.com/DashCampbell/Edmonton-Public-Library-PHP-Emulation/assets/90148639/105b8a19-8364-4292-a868-b1df5f6af801

