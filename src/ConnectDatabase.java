import java.sql.*;

public class ConnectDatabase {

    private boolean success;

    public ConnectDatabase() {
        success = false;
    }

    public boolean connect() {
        boolean hasRegisteredUsers = false;
        final String MYSQL_SERVER_URL = "jdbc:mysql://445sql.mysql.database.azure.com:3306";
        final String DB_NAME = "users";  // Replace with your actual database name
        final String DB_URL = MYSQL_SERVER_URL + "/" + DB_NAME;
        final String USERNAME = "admin445";
        final String PASSWORD = "tcss445!";

        try {
            // First, connect to MYSQL server and create the database if not created
            Connection conn = DriverManager.getConnection(MYSQL_SERVER_URL, USERNAME, PASSWORD);
            Statement statement = conn.createStatement();
            statement.close();
            conn.close();

            // Second, connect to the database and create the table "users" if not created
            conn = DriverManager.getConnection(DB_URL, USERNAME, PASSWORD);
            statement = conn.createStatement();
            String sql = "CREATE TABLE IF NOT EXISTS users("
                    + "id INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,"
                    + "name VARCHAR(200) NOT NULL,"
                    + "email VARCHAR(200) NOT NULL UNIQUE,"
                    + "phone VARCHAR(200),"
                    + "address VARCHAR(200),"
                    + "password VARCHAR(200) NOT NULL"
                    + ")";
            statement.executeUpdate(sql);

            // Check if we have users in the table "users"
            statement = conn.createStatement();
            ResultSet resultSet = statement.executeQuery("SELECT COUNT(*) FROM users");
            success = true;
            if (resultSet.next()) {
                int numUsers = resultSet.getInt(1);
                if (numUsers > 0) {
                    hasRegisteredUsers = true;
                }
            }
            statement.close();
            conn.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return hasRegisteredUsers;
    }

    public boolean isSuccess() {
        return success;
    }

    public User addUserToDatabase(String name, String email, String phone, String address, String password) {
        User user = null;
        final String DB_URL = "jdbc:mysql://445sql.mysql.database.azure.com:3306/users";
        final String USERNAME = "admin445";
        final String PASSWORD = "tcss445!";

        try {
            Connection conn = DriverManager.getConnection(DB_URL, USERNAME, PASSWORD);

            // Connected to the database successfully...

            String sql = "INSERT INTO users (name, email, phone, address, password) " +
                    "VALUES (?, ?, ?, ?, ?)";
            try (PreparedStatement preparedStatement = conn.prepareStatement(sql)) {
                preparedStatement.setString(1, name);
                preparedStatement.setString(2, email);
                preparedStatement.setString(3, phone);
                preparedStatement.setString(4, address);
                preparedStatement.setString(5, password);

                // Insert row into the table
                int addedRows = preparedStatement.executeUpdate();
                if (addedRows > 0) {
                    user = new User();
                    user.name = name;
                    user.email = email;
                    user.phone = phone;
                    user.address = address;
                    user.password = password;
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return user;
    }

}
