CREATE TABLE employees (employee_id INTEGER PRIMARY KEY AUTO_INCREMENT,
                        first_name VARCHAR(255) NOT NULL,
                        last_name VARCHAR(255) NOT NULL,
                        position VARCHAR(255),
                        image VARCHAR(255));

CREATE TABLE tasks (task_id INTEGER PRIMARY KEY AUTO_INCREMENT,
                    description VARCHAR(255),
                    assigned_to INTEGER REFERENCES employees(employee_id) ON DELETE SET NULL,
                    estimate INTEGER,
                    status VARCHAR(255));




