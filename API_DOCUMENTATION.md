# English Learning LMS - Student API Documentation

This document provides the API endpoints for the Flutter application to interact with the English Learning LMS.

## Base URL
`http://your-domain.com/api`

---

## 1. Authentication

### Student Login
**Endpoint:** `POST /login`  
**Description:** Authenticate a student and receive an API token.

**Request Body:**
```json
{
    "email": "student@example.com",
    "password": "password123"
}
```

**Success Response:**
```json
{
    "status": "success",
    "token": "1|ABC...",
    "student": {
        "id": 1,
        "name": "Jane Doe",
        "email": "student@example.com",
        "course_id": 1,
        "status": "active"
    }
}
```

### Student Registration
**Endpoint:** `POST /register`  
**Description:** Create a new student account.

**Request Body:**
```json
{
    "name": "Alex Smith",
    "email": "alex@example.com",
    "phone": "9876543210",
    "password": "securepassword",
    "course_id": 1
}
```

**Success Response:**
```json
{
    "status": "success",
    "message": "Student registered successfully",
    "token": "2|XYZ...",
    "student": {
        "id": 2,
        "name": "Alex Smith",
        "email": "alex@example.com",
        "course_id": 1,
        "status": "active"
    }
}
```

---

## 2. Courses & Content (Public)

### Get All Courses
**Endpoint:** `GET /courses`  
**Description:** Fetch a list of all available courses.

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "title": "Basic English",
            "duration_days": 90,
            "price": "49.99"
        }
    ]
}
```

### Get Levels by Course
**Endpoint:** `GET /levels/{course_id}`  
**Description:** Fetch all levels associated with a specific course.

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "name": "Level 1 - Introduction",
            "course_id": 1
        }
    ]
}
```

### Get Lessons by Level
**Endpoint:** `GET /lessons/{level_id}`  
**Description:** Fetch all lessons within a specific level.

**Response:**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "title": "Alphabet Basics",
            "day_number": 1,
            "level_id": 1
        }
    ]
}
```

### Get Lesson Details (Includes Quizzes)
**Endpoint:** `GET /lesson-details/{id}`  
**Description:** Fetch full details of a lesson, including its associated quiz questions.

**Response:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "title": "Alphabet Basics",
        "video_url": "https://...",
        "notes": "...",
        "quizzes": [
            {
                "id": 1,
                "question": "What is the first letter?",
                "option_a": "A",
                "option_b": "B",
                "option_c": "C",
                "option_d": "D",
                "correct_answer": "a"
            }
        ]
    }
}
```

---

## 3. Student Actions (Authentication Required)
*All requests below must include the `Authorization: Bearer {token}` header.*

### Get Student Progress
**Endpoint:** `GET /student-progress`  
**Description:** Fetch the student's learning stats and recent quiz results.

**Response:**
```json
{
    "status": "success",
    "data": {
        "completed_lessons": 12,
        "total_score": 1150,
        "recent_results": [
            {
                "lesson_id": 1,
                "score": 100,
                "lesson": { "title": "Alphabet Basics" }
            }
        ]
    }
}
```

### Submit Quiz Result
**Endpoint:** `POST /submit-result`  
**Description:** Save or update a quiz score for a lesson.

**Request Body:**
```json
{
    "lesson_id": 1,
    "score": 85
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Result saved successfully",
    "data": {
        "student_id": 1,
        "lesson_id": 1,
        "score": 85
    }
}
```

### Get Profile Details
**Endpoint:** `GET /profile`  
**Description:** Fetch the authenticated student's profile information.

**Response:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Jane Doe",
        "email": "student@example.com",
        "phone": "1234567890"
    }
}
```

### Update Profile
**Endpoint:** `PUT /update-profile`  
**Description:** Update student name, phone, or password.

**Request Body:**
```json
{
    "name": "Jane Updated",
    "phone": "0987654321",
    "password": "newpassword123" 
}
```
*(password is optional)*

**Response:**
```json
{
    "status": "success",
    "message": "Profile updated successfully",
    "data": {
        "id": 1,
        "name": "Jane Updated"
    }
}
```
