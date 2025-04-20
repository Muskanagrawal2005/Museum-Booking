-- First, delete existing shows
DELETE FROM shows;

-- Insert new shows with their descriptions and prices
INSERT INTO shows (name, description, price, available_slots) VALUES
('Mughal Era Treasures', 'Explore the opulent world of Mughal art and architecture', 100.00,
'["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'),

('Ancient Indian Civilizations', 'Journey through time to discover India\'s ancient heritage', 75.00,
'["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'),

('Modern Art Revolution', 'Witness the evolution of Indian art in the modern era', 150.00,
'["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'),

('Digital Art & Technology', 'Explore the intersection of traditional art and modern technology', 150.00,
'["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]');
