import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class Main {
    public static void main(String[] args) {
        String jdbcUrl = "!;encrypt=true;trustServerCertificate=false;hostNameInCertificate=*.database.windows.net;loginTimeout=10;";
        ConnectDatabase conn = new ConnectDatabase();
        conn.connect();
        conn.addUserToDatabase("Greg", "gyi@uw.edu", "2543120380", "123 bob lnae", "123");




    }
}