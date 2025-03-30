-- Drop existing tables (if they exist)
DROP TABLE IF EXISTS art_thing_user_challenges CASCADE;
DROP TABLE IF EXISTS art_thing_saved_prompts CASCADE;
DROP TABLE IF EXISTS art_thing_challenges CASCADE;
DROP TABLE IF EXISTS art_thing_users CASCADE;

-- Create users table
CREATE TABLE art_thing_users (
    user_id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create challenges table
CREATE TABLE art_thing_challenges (
    challenge_id SERIAL PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    type VARCHAR(50) NOT NULL,
    duration VARCHAR(20) NOT NULL,
    materials TEXT,
    created_by INTEGER REFERENCES art_thing_users(user_id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create saved_prompts table
CREATE TABLE art_thing_saved_prompts (
    prompt_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES art_thing_users(user_id) ON DELETE CASCADE,
    prompt_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create user_challenges table (for tracking completed challenges)
CREATE TABLE art_thing_user_challenges (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES art_thing_users(user_id) ON DELETE CASCADE,
    challenge_id INTEGER REFERENCES art_thing_challenges(challenge_id) ON DELETE CASCADE,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert some sample challenges
INSERT INTO art_thing_challenges (title, description, type, duration, materials, created_by) VALUES
('Single Crayon Challenge', 'Create an artwork using only one crayon color of your choice. Focus on shading techniques and value contrast to create a complete image.', 'material', 'medium', 'One crayon of your choice', NULL),
('5-Minute Gesture Drawing', 'Practice quick gesture drawings to improve your ability to capture movement and form rapidly. Do five 1-minute drawings without lifting your pencil from the paper.', 'process', 'quick', 'Pencil and paper', NULL),
('Urban Nature Speedpaint', 'Use watercolors to capture nature in an urban setting. Complete this in 30 minutes. Focus on the theme of contrast between natural and built environments.', 'material,process,concept', 'medium', 'Watercolors, paper, brushes', NULL),
('Negative Space Study', 'Create a drawing by focusing only on the negative space around your subject. This helps train your eye to see shapes differently.', 'process,concept', 'medium', 'Any drawing medium', NULL),
('Memory Drawing', 'Choose an object, study it for 1 minute, then put it away and draw it from memory. Great exercise for improving observation skills.', 'concept', 'quick', 'Any drawing medium', NULL),
('Monochrome Expression', 'Create a piece that expresses a strong emotion using only one color (plus black and white). Focus on how value and composition can convey feeling.', 'material,concept', 'medium', 'Any medium with value range', NULL);