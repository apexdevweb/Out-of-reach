DELIMITER $$
CREATE PROCEDURE AdminAccessByIp(IN p_ip VARCHAR(45))
BEGIN
    SELECT * FROM ofr_admin WHERE admin_ofr_ip = p_ip LIMIT 1;
END $$

CREATE PROCEDURE AdminToAdminPage(IN p_id INT)
BEGIN
    SELECT admin_ofr_key FROM ofr_admin WHERE admin_ofr_id = p_id;
END $$
DELIMITER;