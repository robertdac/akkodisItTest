# Akkodis IT Test

This project provides a simple API to authenticate users and retrieve shift data. It includes user login, middleware access control, and shift filtering by date and other parameters.

## 📦 Installation

Clone the `develop` branch:

```bash
git clone -b develop https://github.com/robertdac/akkodisItTest.git
cd akkodisItTest

composer install

php artisan migrate 

php artisan test --filter="Shift(Access|Query)Test"

php artisan migrate:fresh --seed

php artisan serve

"For this test, we take the first user from the users table."

POST /api/v1/login
Content-Type: application/json
Accept: application/json
{
  "email": "carter.raphael@example.org",
  "password": "password"
}

Response 

{
  "token": "1|qeoEQySxBWuEFwFX6y8Gi3AzwI5r1Zsin94cvcsB453e51c4",
  "user": {
    "id": 1,
    "name": "Tyrel Schultz",
    "last_name": "Reynolds",
    "email": "lilian.schinner@example.org",
    "email_verified_at": "2025-06-30T07:21:24.000000Z",
    "created_at": "2025-06-30T07:21:24.000000Z",
    "updated_at": "2025-06-30T07:21:24.000000Z"
  }
}

GET /api/v1/users/3/shifts?start=2025-04-19&end=2025-07-30
Authorization: Bearer 1|qeoEQySxBWuEFwFX6y8Gi3AzwI5r1Zsin94cvcsB453e51c4
Content-Type: application/json
Accept: application/json

Response

{
  "data": [
    {
      "type": "Vacation",
      "start_date": "29/05/2025 02:03",
      "end_date": "03/06/2025 02:03",
      "days": 6,
      "hours": 120
    },
    {
      "type": "Off",
      "start_date": "25/06/2025 15:16",
      "end_date": "26/06/2025 15:16",
      "days": 2,
      "hours": 24
    }
  ]
}

GET /api/v1/users/3/shifts?start=2025-04-19&end=2025-07-30&first=1
Authorization: Bearer 1|qeoEQySxBWuEFwFX6y8Gi3AzwI5r1Zsin94cvcsB453e51c4
Content-Type: application/json
Accept: application/json

Response

{
  "data": {
    "type": "Off",
    "start_date": "25/06/2025 15:16",
    "end_date": "26/06/2025 15:16",
    "days": 2,
    "hours": 24
  }
}
