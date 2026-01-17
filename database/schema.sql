CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    user_type ENUM('super_admin','association_admin','staff','member') NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE states (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE districts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    state_id INT UNSIGNED NOT NULL,
    name VARCHAR(150) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uq_district_state (state_id, name),

    CONSTRAINT fk_districts_state
        FOREIGN KEY (state_id)
        REFERENCES states(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE associations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(150) NOT NULL,
    association_code VARCHAR(50) NOT NULL,

    district_id INT UNSIGNED NOT NULL,

    service_start_date DATE NOT NULL,
    service_end_date DATE NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE association_admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    association_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    mobile VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    designation VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,

    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uniq_admin_email (email),

    CONSTRAINT fk_admin_association
        FOREIGN KEY (association_id)
        REFERENCES associations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE member_categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    association_id INT UNSIGNED NOT NULL,

    name VARCHAR(100) NOT NULL,

    validity_type ENUM('monthly','quarterly','half_yearly','yearly','lifetime') NOT NULL,
    payment_periodicity ENUM('monthly','quarterly','half_yearly','yearly') NOT NULL,

    amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    description TEXT DEFAULT NULL,

    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_category_per_association (association_id, name),

    CONSTRAINT fk_member_category_association
        FOREIGN KEY (association_id)
        REFERENCES associations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE members (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    association_id INT UNSIGNED NOT NULL,
    member_category_id INT UNSIGNED NOT NULL,

    house_number VARCHAR(50) NOT NULL,
    owner_name VARCHAR(150) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,

    occupants INT DEFAULT NULL,
    location VARCHAR(150) DEFAULT NULL,
    remarks TEXT DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_members_association
        FOREIGN KEY (association_id)
        REFERENCES associations(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_members_category
        FOREIGN KEY (member_category_id)
        REFERENCES member_categories(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE fee_heads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    association_id INT UNSIGNED NOT NULL,

    name VARCHAR(150) NOT NULL,
    amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    periodicity ENUM('monthly','quarterly','half_yearly','yearly') NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_fee_head_per_association (association_id, name),

    CONSTRAINT fk_fee_heads_association
        FOREIGN KEY (association_id)
        REFERENCES associations(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE category_fee_heads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    member_category_id INT UNSIGNED NOT NULL,
    fee_head_id INT UNSIGNED NOT NULL,

    is_mandatory TINYINT(1) NOT NULL DEFAULT 1,

    UNIQUE KEY uniq_category_fee (member_category_id, fee_head_id),

    CONSTRAINT fk_cfh_category
        FOREIGN KEY (member_category_id)
        REFERENCES member_categories(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_cfh_fee_head
        FOREIGN KEY (fee_head_id)
        REFERENCES fee_heads(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE bills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    member_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,

    bill_month TINYINT NOT NULL,
    bill_year SMALLINT NOT NULL,

    due_date DATE NOT NULL,

    total_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    outstanding_amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    status ENUM('unpaid','partial','paid') NOT NULL DEFAULT 'unpaid',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY uniq_member_month_year (member_id, bill_month, bill_year),

    CONSTRAINT fk_bills_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_bills_category
        FOREIGN KEY (category_id)
        REFERENCES member_categories(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE bill_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    bill_id INT UNSIGNED NOT NULL,

    item_type VARCHAR(50) NOT NULL,
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_bill_items_bill
        FOREIGN KEY (bill_id)
        REFERENCES bills(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;