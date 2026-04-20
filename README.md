# Jeopardy Game Web Application

## Team Members
- Uddhav Cota
- [Teammate Name]

## Live Deployment (CODD)
The application is hosted on CODD and can be accessed here:

https://codd.cs.gsu.edu/~ucota1/Web_Pro/JeopardyGame/login.php

## Project Description
This project is a Jeopardy-style quiz web application built using PHP, HTML, and CSS. Users can register, log in, play a quiz game, answer questions, and track their scores on a leaderboard.

## Features
- User authentication (login and register)
- Jeopardy-style game board with categories and point values
- Dynamic question system
- Answer validation and scoring
- Session-based game state tracking
- Persistent leaderboard using file storage
- Reset game functionality

## How to Run (Local - Optional)
1. Place the project folder inside the XAMPP `htdocs` directory
2. Start Apache using XAMPP
3. Open browser and go to:
   http://localhost/JeopardyGame

## Technologies Used
- PHP (server-side logic)
- HTML5 (structure)
- CSS3 (styling and layout)
- Sessions (state management)
- File storage (leaderboard persistence)

## File Structure
- game.php → game board
- question.php → displays question
- result.php → processes answers
- leaderboard.php → shows leaderboard
- login.php → user login
- register.php → user registration
- dashboard.php → navigation
- data/questions.php → question data
- data/scores.txt → leaderboard storage

## AI Usage Disclosure
This project used AI tools (ChatGPT) to assist with:
- debugging PHP logic
- generating initial code structure
- improving code clarity and organization

All code was reviewed, modified, and understood by the developers before submission.

## Future Improvements
- Store only highest score per user
- Add database support instead of file storage
- Improve mobile responsiveness
- Add more categories and questions