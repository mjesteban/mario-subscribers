
# MailerLite - PHP Integration Developer Assignment
_April 12th 2023_

The task is to create a simple PHP application for managing the subscribers of a MailerLite account via the [MailerLite API](https://developers.mailerlite.com/docs/#mailerlite-api). Assignment should be completed within five business days.
## Installation 🛠
### Prerequisites
- [Docker](https://docs.docker.com/get-docker/)

### Script
No worries, no harmful hidden agendas. Just copy and paste on your installation directory.
```
git clone https://github.com/mjesteban/mario-subscribers.git \
	&& cd mario-subscribers \
	&& docker run --rm \
		-u "$(id -u):$(id -g)" \
		-v $(pwd):/var/www/html \
		-w /var/www/html \
		laravelsail/php74-composer:latest \
		composer install --ignore-platform-reqs \
	&& alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail' \
	&& cp .env.example .env \
	&& sail up -d \
	&& echo -e "\033[0;31m'Rivers know this: there is no hurry. We shall get there some day.' ― A A. Milne, Winnie-the-Pooh\033[0m" \
	&& sleep 5 \
	&& sail npm install \
	&& sail npm run prod \
	&& sail mysql < import.sql \
	&& echo -e "\033[32m'A goal is a dream with a finish line.' - Duke Ellington\033[0m | Link: http://localhost:14344"
```
> http://localhost:14344
## Experience 🎡

### Introduction
From the moment I received the instructions from the HR Manager, I dived right in. The instructions were well-written, so I didn't need any follow-up questions.

### Working with Laravel Sail
As a backend-focused developer, I had more in-depth experience with Docker or Docker Compose, but using Laravel's Sail was slightly easier. The challenging part was setting it up according to the requirements, but fiddling around with the docker-compose.yml, environment variables, and installation script was rewarding, knowing that the installation script worked just fine.

### Frontend Work with Laravel Mix and DataTables
Although I'm a neophyte when it comes to working with Laravel Mix, I was able to set it up after a while. Instead of relying on jQuery, I challenged myself by using modern ES6 JavaScript syntax for displaying data utilizing DataTables. I used Bootstrap 5.2 for the styling, selecting an open-sourced Bootswatch theme--[Darkly](https://bootswatch.com/darkly/).

### HTTP Client Implementation
I started coding using Guzzle, but then noticed that Laravel's HTTP Client implementation was different. To avoid parsing overheads, I ended up utilizing the Laravel HTTP facade.

### Request Validations
I did not use the required tag on the input forms so that validations are purely handled by the backend as well as relay the error responses from the MailerLite API.

### Code Organization and Standards
The code is fairly self-documenting, crafted on my handy-dandy PHPStorm IDE, and used [Prettier](https://github.com/prettier/plugin-php) to conform to PSR-2 standards.

---
> As part of the requirement, I've disabled CSRF by commenting it out on the Kernel. No migrations done since the .sql file is already part of
> the installation. It also does not involve user authentication.

## Pitfalls ⚠️

- No way to just ping the MailerLite API, which led me to utilize one of its endpoints just to determine if the API key is valid

## Roadmap 🚧

_Some stuff that I'd continue if there had been more time_

- With limited experience on TDD—I would start writing tests and API validation first such as converting the assignment instructions into test functions
- DRY repeated code
- A more Design Pattern eccentric API service so that it is reusable through the other endpoints
- Refactor until its simplest form
- Add the backend tests
- Strip unnecessary dependencies caused by default Laravel installation

## Acknowledgments 🙌

The specification for this programming test came from [MailerLite](https://www.mailerlite.com/).
