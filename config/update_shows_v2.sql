-- Update or insert shows while preserving existing IDs
UPDATE shows SET 
    name = 'Mughal Era Treasures',
    description = 'Explore the opulent world of Mughal art and architecture',
    price = 100.00,
    available_slots = '["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'
WHERE id = 1;

UPDATE shows SET 
    name = 'Ancient Indian Civilizations',
    description = 'Journey through time to discover India\'s ancient heritage',
    price = 75.00,
    available_slots = '["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'
WHERE id = 2;

UPDATE shows SET 
    name = 'Modern Art Revolution',
    description = 'Witness the evolution of Indian art in the modern era',
    price = 150.00,
    available_slots = '["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'
WHERE id = 3;

-- Insert the fourth show if it doesn't exist
INSERT INTO shows (name, description, price, available_slots)
SELECT 'Digital Art & Technology', 
       'Explore the intersection of traditional art and modern technology',
       150.00,
       '["10:00 AM", "12:00 PM", "02:00 PM", "04:00 PM", "06:00 PM"]'
WHERE NOT EXISTS (SELECT 1 FROM shows WHERE id = 4);
