SELECT 
      deck.deck_id AS deck_id, 
      deck.user_id AS user_id, 
      deck.deck_name AS deck_name, 
      bgm.bgm AS bgm, 
      van_card.image AS van_image, 
      van_card.barcode AS van_barcode, 
      van_name.name AS van_name, 
      van_card.form AS van_form, 
      van_card.skill AS van_skill, 
      van_card.climax AS van_climax, 
      van_type.type AS van_type, 
      van_prog.prog AS van_prog, 
      van_rare.rare AS van_rare, 
      rear_card.image AS rear_image, 
      rear_card.barcode AS rear_barcode, 
      rear_name.name AS rear_name, 
      rear_card.form AS rear_form, 
      rear_card.skill AS rear_skill, 
      rear_card.climax AS rear_climax, 
      rear_type.type AS rear_type, 
      rear_prog.prog AS rear_prog, 
      rear_rare.rare AS rear_rare  
      FROM deck
      LEFT JOIN user on deck.user_id = user.user_id
      LEFT JOIN m_card AS van_card ON deck.van_id = van_card.card_id
      LEFT JOIN m_name AS van_name ON van_card.name_id = van_name.name_id
      LEFT JOIN m_prog AS van_prog ON van_card.prog_id = van_prog.prog_id
      LEFT JOIN m_rare AS van_rare ON van_card.rare_id = van_rare.rare_id
      LEFT JOIN m_type AS van_type ON van_card.type_id = van_type.type_id
      LEFT JOIN m_card AS rear_card ON deck.rear_id = rear_card.card_id
      LEFT JOIN m_name AS rear_name ON rear_card.name_id = rear_name.name_id
      LEFT JOIN m_prog AS rear_prog ON rear_card.prog_id = rear_prog.prog_id
      LEFT JOIN m_rare AS rear_rare ON rear_card.rare_id = rear_rare.rare_id
      LEFT JOIN m_type AS rear_type ON rear_card.type_id = rear_type.type_id
      LEFT JOIN bgm on deck.bgm_id = bgm.bgm_id
      ORDER BY deck.deck_id;