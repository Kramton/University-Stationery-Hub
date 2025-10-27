# University Stationery Hub

The objective of this project is to provide a convenient and accessible e-commerce website platform for university students and faculty to purchase stationary items and services within campus, offering cost-effective solutions such as student discounts and promotions. 

This guide explains how to set up the project locally on Windows with XAMPP. If you use a MacOS or Linux device, please install the correct version for your device.

## Prerequisites

- Windows with XAMPP https://www.apachefriends.org/

## Project paths and URLs

This project assumes it lives at this path and URL by default:

- Folder: `C:\\xampp\\htdocs\\University-Stationery-Hub`
- URL: `http://localhost/University-Stationery-Hub/`

## Quick start

1) Place the project in your XAMPP htdocs

- C:\\xampp\\htdocs
- If you cloned elsewhere, move/copy the folder here
- Ensure the folder name is exactly: University-Stationery-Hub

2) Start Apache and MySQL

- Open the XAMPP Control Panel
- Start “Apache” and “MySQL”

3) Create the database and import schema/data

- Import `sql/php_project.sql` using phpMyAdmin:
  - Open `http://localhost/phpmyadmin/`
  - Go to Import tab
  - Click `Choose File` button and select `sql/php_project.sql`
  - Click `Import` button at the bottom.

4) Open the app

Visit:

- Webpage: `http://localhost/University-Stationery-Hub/`
- Admin: `http://localhost/University-Stationery-Hub/admin/`

Create a customer account via Register. You’ll receive a verification email with a link like:

```
http://localhost/University-Stationery-Hub/verify_account.php?token=...
```

If links don’t open, copy/paste the full URL from the email into your browser.

## Credits / Tool kits used

- Bootstrap: https://getbootstrap.com/docs/5.3/getting-started/introduction/
- Font Awesome: https://fontawesome.com/v4/icons/
- Google Fonts: https://fonts.google.com/
- PHPMailer: https://github.com/PHPMailer/PHPMailer