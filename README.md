# Emergency Severity Triage Classification Web Application

This web application is an implementation of the Emergency Severity Index (ESI) triage classification system for emergency department patients. The application uses a one-dimensional Convolutional Neural Network (1D CNN) model to predict the triage level of patients based on their vital signs and chief complaints, helping healthcare workers make faster and more accurate triage decisions.

## Features

- **Patient Registration**: Collect basic demographic information (name, age, gender)
- **Vital Signs Input**: Record key vital signs (blood pressure, heart rate, respiratory rate, temperature, oxygen saturation)
- **Chief Complaint Selection**: Choose from comprehensive list of standardized chief complaints
- **Automated Triage Classification**: Predicts ESI triage level (1-5) using an AI model
- **Validation System**: Allows healthcare professionals to validate and override model predictions
- **Dashboard**: View and manage triage records with statistics on prediction accuracy
- **User Management**: Role-based access control for different user types

## Technical Information

### System Requirements

- PHP 8.0 or higher
- Laravel Framework
- MySQL/PostgreSQL database
- Web server (Apache/Nginx)
- Connectivity to the triage classification API

### Model Connection

This application connects to the pre-trained 1D CNN model via REST API endpoints. The model processes the patient data and returns a predicted ESI triage level from 1 (most urgent) to 5 (least urgent).

### Screenshots

[Screenshots will be added here]

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/your-username/Emergency-Severity-Triage-Classification-Web
   ```

2. Install dependencies:
   ```
   composer install
   npm install
   ```

3. Create and configure the .env file:
   ```
   cp .env.example .env
   ```

4. Generate application key:
   ```
   php artisan key:generate
   ```

5. Configure the database connection in the .env file and run migrations:
   ```
   php artisan migrate
   ```

6. Seed the database with initial data:
   ```
   php artisan db:seed
   ```

7. Configure API connection in .env:
   ```
   API_TRIASE=http://your-model-api-url
   ```

8. Start the development server:
   ```
   php artisan serve
   ```

## Usage

1. Register/login to the application
2. Enter patient information (demographics and vital signs)
3. Select applicable chief complaints from the standardized list
4. Submit to receive triage prediction
5. Review and validate the triage level as needed

## Related Repositories

This web application is part of a larger research project. The other components can be found at:

- Model Development: [Emergency-Severity-Triage-Classification](https://github.com/hana-ri/Emergency-Severity-Triage-Classification)
- API Service: [Emergency-Severity-Triage-Classification-API](https://github.com/hana-ri/Emergency-Severity-Triage-Classification-API)

## Research Background

This work is based on research that was published as:

### DESIGN OF A TRIAGE LEVEL CLASSIFICATION APPLICATION FOR IGD PATIENTS USING ONE-DIMENSIONAL CNN ARCHITECTURE
- **Author**: Mohamad Rizal Hanafi
- **Published**: 2024/2/25
- **Institution**: Universitas Pendidikan Indonesia

### Summary
This research addressed emergency room overcrowding by developing a 5-level ESI triage classification system using 1D CNN architecture. The model achieved 81% accuracy (precision, recall, and f1-score of 0.81), outperforming neural networks (78%), XGBoost (75%), and logistic regression (70%). The resulting web application passed all functional testing requirements.

### Thesis Repository
[https://repository.upi.edu/120201](https://repository.upi.edu/120201)
