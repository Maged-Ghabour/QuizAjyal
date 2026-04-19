-- =====================================================
-- Migration: Add word_order to questions type ENUM
-- Run this on your Hostinger MySQL database
-- =====================================================

ALTER TABLE questions
MODIFY COLUMN type ENUM(
    'mcq',
    'fill_blank',
    'match',
    'image_choice',
    'drag_drop',
    'true_false',
    'passage',
    'essay',
    'word_order'
) NOT NULL;

-- Verify the change
-- DESCRIBE questions;
