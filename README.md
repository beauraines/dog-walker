# Dog Walk Service Scheduler

## Features

* New clients to sign up and make bookings for various services, e.g walk or visit
    * Clients can have multiple pets
* Walkers to set their availability
* Bill and invoice clients for their services (TBD)


## Installation

1. Clone the repository
1. `composer install`
1. Configure your `.env`
    1. `APP_NAME`
    2. `APP_KEY`
    3. Database configuration
    4. Mail driver
1. `artisan config:cache`
1. `artisan migrate`

## License
The Dog Walker Service Scheduler is a free package released under the MIT License.



