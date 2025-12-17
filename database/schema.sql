CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    user_type ENUM('super_admin', 'association_admin', 'member') NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS associations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    local_body_id VARCHAR(100) NOT NULL,
    location VARCHAR(150) NOT NULL,
    district_id VARCHAR(100) NOT NULL,
    association_code VARCHAR(100) NOT NULL UNIQUE,
    reg_number VARCHAR(100) NOT NULL,
    registered_with VARCHAR(150) NOT NULL,
    valid_from DATE NOT NULL,
    valid_to DATE NOT NULL,
    service_end_date DATE NOT NULL,
    admin_user_id INT NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    CONSTRAINT fk_association_admin_user FOREIGN KEY (admin_user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    association_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    member_code VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    house_name VARCHAR(150),
    street_name VARCHAR(150),
    local_body_id VARCHAR(100),
    ward_number VARCHAR(50),
    door_number VARCHAR(50),
    door_sub_number VARCHAR(50),
    user_id INT NOT NULL,
    UNIQUE KEY unique_member_code (association_id, member_code),
    CONSTRAINT fk_member_association FOREIGN KEY (association_id) REFERENCES associations(id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_member_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
