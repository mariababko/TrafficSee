import javax.swing.*;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileWriter;
import java.io.IOException;
import java.sql.*;
import java.util.Arrays;
import java.util.Scanner;

/**
 * User Class
 * @Author Gregory Yi, JD
 * @Version 2.0
 */
public class User {
    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPhone() {
        return phone;
    }

    public void setPhone(String phone) {
        this.phone = phone;
    }

    public String getAddress() {
        return address;
    }

    public void setAddress(String address) {
        this.address = address;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String name;
    public String email;
    public String phone;
    public String address;
    public String password;

    public User user;

    /**
     * Author Gregory Yi
     */
    private User addUserToDatabase(String name, String email, String phone, String address, String password) {
        User user = null;
        final String DB_URL = "jdbc:sqlserver://tcss445.database.windows.net:1433;database=TCSS445Project;user=admin445@tcss445;password=tcss445!;encrypt=true;trustServerCertificate=false;hostNameInCertificate=*.database.windows.net;loginTimeout=10;";
        final String USERNAME = "orange";
        final String PASSWORD = "!Team360";

        try{
            Connection conn = DriverManager.getConnection(DB_URL, USERNAME, PASSWORD);
            // Connected to database successfully...

            Statement stmt = conn.createStatement();
            String sql = "INSERT INTO users (name, email, phone, address, password) " +
                    "VALUES (?, ?, ?, ?, ?)";
            PreparedStatement preparedStatement = conn.prepareStatement(sql);
            preparedStatement.setString(1, name);
            preparedStatement.setString(2, email);
            preparedStatement.setString(3, phone);
            preparedStatement.setString(4, address);
            preparedStatement.setString(5, password);

            //Insert row into the table
            int addedRows = preparedStatement.executeUpdate();
            if (addedRows > 0) {
                user = new User();
                user.name = name;
                user.email = email;
                user.phone = phone;
                user.address = address;
                user.password = password;
            }
            stmt.close();
            conn.close();
        }catch(Exception e){
            e.printStackTrace();
        }
        return user;
    }




}