-- Drop existing tables if they exist
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS challenges CASCADE;
DROP TABLE IF EXISTS saved_prompts CASCADE;
DROP TABLE IF EXISTS user_challenges CASCADE;

-- Create users table
CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create challenges table
CREATE TABLE challenges (
    challenge_id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    type VARCHAR(50) NOT NULL, -- material, process, theme
    duration VARCHAR(20) NOT NULL, -- quick, medium, long
    materials TEXT,
    created_by INT REFERENCES users(user_id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create saved_prompts table
CREATE TABLE saved_prompts (
    prompt_id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id),
    prompt_text TEXT NOT NULL,
    medium TEXT,
    style TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create user_challenges table (for tracking completed challenges)
CREATE TABLE user_challenges (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(user_id),
    challenge_id INT REFERENCES challenges(challenge_id),
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample challenges
INSERT INTO challenges (title, description, type, duration, materials) VALUES
('Single Crayon Challenge', 'Create an artwork using only one crayon color of your choice. Focus on shading techniques and value contrast to create a complete image.', 'material', 'medium', 'One crayon of your choice'),
('5-Minute Gesture Drawing', 'Practice quick gesture drawings to improve your ability to capture movement and form rapidly. Do five 1-minute drawings without lifting your pencil from the paper.', 'process', 'quick', 'Pencil and paper'),
('Memory Drawing', 'Choose an object, study it for 1 minute, then put it away and draw it from memory. Great exercise for improving observation skills.', 'theme', 'medium', 'Any drawing medium');