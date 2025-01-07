# Soccer Field Reservation


## Features

- **Feature 1**: Manage business for Soccer yard owner (reservation, revenue).
- **Feature 2**: Online payment (stripe, momo).
- **Feature 3**: Booking yard, get the discount.

## Prerequisites

Before setting up the project, ensure you have the following installed:

- PHP >= 8.2
- Composer
- Laravel Framework
- MySQL Database
- Node.js and npm/yarn (if applicable)

## Installation

Follow these steps to set up the project locally:

1. Clone the repository.

2. Navigate to the project directory

3. Install dependencies using Composer:
   ```bash
   composer install
   ```

4. Install JavaScript dependencies:
   ```bash
   npm install
   # or
   yarn install
   ```


5. Set up the `.env` file:
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Update the environment variables with your database and other configurations.

    `.env` configuration for MoMo test mode:
   ```env
   MOMO_PARTNER_CODE=MOMOBKUN20180529
   MOMO_ACCESS_KEY=klm05TvNBzhg7h7j
   MOMO_SECRET_KEY=at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa
   ```
   Example `.env` configuration for Stripe test mode:
   ```env
   STRIPE_PUBLISHABLE_KEY=pk_test_51H9xOjT...
   STRIPE_SECRET_KEY=sk_test_51H9xOjT...
   ```
   You can get the key by register at: [Link text Here](https://dashboard.stripe.com/)

6. Generate the application key:
   ```bash
   php artisan key:generate
   ```

7. Run database migrations:
   ```bash
   php artisan migrate
   ```

8. Seed the database (if applicable):
   ```bash
   php artisan db:seed
   ```

## Usage

### Start the server

Run the following command to start the local development server:

```bash
    php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

### Running the Frontend

If your project has a frontend build process (like React, Vue, or other tools):

```bash
npm run dev
# or
yarn dev
```

### Running Queue Worker

To process queued jobs, run the following command:

```bash
php artisan queue:work
```

### Running Scheduler

To ensure scheduled tasks are executed, add the following cron job to your server:

```bash
php artisan schedule:work
```

### Important Note for Testing

Ensure that you use a separate testing database to avoid data loss or corruption in your main database. Update the `DB_DATABASE` value in your `.env` file specifically for testing:

```env
DB_DATABASE=your_testing_database
```

## Testing

To run tests, use the following command:

```bash
php artisan test
```

## Add Data
To add data following the  [Link text Here](https://dashboard.stripe.com/), download and add that data to database

