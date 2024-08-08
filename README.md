# Scandiweb eCommerce
### Live web site http://somthingetcidontcare.rf.gd/?i=1#/
## Overview

This project is a full-stack eCommerce application built with:

- **Frontend**: React (class components) with TypeScript, Tailwind CSS, and Redux Toolkit.
- **Backend**: PHP with GraphQL.

The application is hosted on a Linux server.

## Setup Instructions

### Backend Setup

1. **Configure Database Credentials**

   To set up your database connection, go to `server/Config/database.php` and update the credentials to fit your database connection.

2. **Update Composer Dependencies**

   Navigate to the `server` directory and run:

   `composer update`

3. **Import Database Backup**

   Download the backup file called `scandweb.sql` and import it into your local MySQL database.

4. **Run Migrations**

   In the `server` directory, run:

   `composer run-script migrate`

5. **Start the Backend**

   To start the backend server, run:

   `composer run-script dev-start`

### Frontend Setup

1. **Update API Endpoints**

   Go to `client/src/requests` and update the API endpoints to point to your local server.

2. **Install Dependencies**

   In the `client` directory, run:

   `npm install`

3. **Start the Frontend**

   To start the frontend development server, run:

   `npm run dev`

## About the App

- **Frontend**: Built using React with class components, TypeScript, Tailwind CSS, and Redux Toolkit for state management.
- **Backend**: Developed in PHP using GraphQL for API interactions.
- **Hosting**: Deployed on a Linux server.

## Notes

- Ensure that you have all required software and dependencies installed before starting.
- For further customization, refer to the configuration files and documentation in the respective directories.

 ## end pint

  - [http://localhost:8000/graphql ](http://138.197.229.66/graphql)

  ### simple query to testing  ` { products  { name id gallery inStock category prices { id amount currency { label symbol } }} } `



