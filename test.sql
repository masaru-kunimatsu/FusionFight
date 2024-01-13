 SELECT * FROM m_card 
 LEFT JOIN m_name on m_card.name_id = m_name.name_id 
 LEFT JOIN m_type on m_card.type_id = m_type.type_id 
 LEFT JOIN m_prog on m_card.prog_id = m_prog.prog_id 
 LEFT JOIN m_rare on m_card.rare_id = m_rare.rare_id 
 WHERE 1 = 1 AND m_card.name = ウルトラマン ORDER BY m_card.card_id