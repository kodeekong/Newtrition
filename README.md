# Newtrition - Nutrition Tracking Application

Newtrition is a comprehensive nutrition tracking application that helps users monitor their daily food intake, track nutritional goals, and maintain a healthy lifestyle. The application provides detailed insights into macronutrients, micronutrients, and overall dietary patterns.

## Features

- **User Authentication**
  - Secure login and registration system
  - User profile management
  - Password recovery functionality

- **Meal Tracking**
  - Log daily meals and snacks
  - Track food items with detailed nutritional information
  - Custom meal creation and management
  - Meal history and analytics

- **Nutrition Analysis**
  - Real-time nutritional calculations
  - Macronutrient breakdown (proteins, carbs, fats)
  - Micronutrient tracking
  - Daily and weekly nutrition summaries

- **Dashboard & Analytics**
  - Visual representation of nutrition data
  - Progress tracking
  - Goal setting and monitoring
  - Customizable reports

## Tech Stack

- **Frontend**
  - React.js
  - Material-UI (MUI) for UI components
  - Chart.js for data visualization
  - React Router for navigation

- **Backend**
  - Node.js
  - Express.js
  - MongoDB for database
  - JWT for authentication

## Getting Started

### Prerequisites

- Node.js (v14 or higher)
- MongoDB
- npm or yarn package manager

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/newtrition.git
   cd newtrition
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Set up environment variables:
   Create a `.env` file in the root directory with the following variables:
   ```
   MONGODB_URI=your_mongodb_connection_string
   JWT_SECRET=your_jwt_secret
   PORT=3000
   ```

4. Start the development server:
   ```bash
   npm run dev
   ```

## Project Structure

```
newtrition/
├── client/                 # Frontend React application
│   ├── public/            # Static files
│   └── src/               # Source files
│       ├── components/    # React components
│       ├── pages/         # Page components
│       ├── services/      # API services
│       └── utils/         # Utility functions
├── server/                # Backend Node.js application
│   ├── controllers/       # Route controllers
│   ├── models/           # Database models
│   ├── routes/           # API routes
│   └── utils/            # Utility functions
└── README.md             # Project documentation
```

## API Documentation

### Authentication Endpoints

- `POST /api/auth/register` - Register a new user
- `POST /api/auth/login` - User login
- `POST /api/auth/forgot-password` - Request password reset
- `POST /api/auth/reset-password` - Reset password

### Meal Endpoints

- `GET /api/meals` - Get all meals
- `POST /api/meals` - Create a new meal
- `GET /api/meals/:id` - Get meal by ID
- `PUT /api/meals/:id` - Update meal
- `DELETE /api/meals/:id` - Delete meal

### Nutrition Endpoints

- `GET /api/nutrition/summary` - Get nutrition summary
- `GET /api/nutrition/analytics` - Get nutrition analytics
- `POST /api/nutrition/goals` - Set nutrition goals

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

Your Name - your.email@example.com
Project Link: https://github.com/yourusername/newtrition

## Acknowledgments

- [React.js](https://reactjs.org/)
- [Material-UI](https://mui.com/)
- [Chart.js](https://www.chartjs.org/)
- [MongoDB](https://www.mongodb.com/)
- [Express.js](https://expressjs.com/)
