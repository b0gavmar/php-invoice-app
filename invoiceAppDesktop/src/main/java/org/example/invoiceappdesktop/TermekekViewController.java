package org.example.invoiceappdesktop;

import javafx.fxml.FXML;
import javafx.stage.Stage;
import javafx.scene.control.Label;
import org.example.invoiceappdesktop.db.Database;
import org.example.invoiceappdesktop.db.ItemDAO;

public class TermekekViewController {

    @FXML
    public void initialize() {
        try {
            ItemDAO dao = new ItemDAO(Database.getConnection());
            int count = dao.getNumberOfItems();
            itemCountLabel.setText("Termékek száma: " + count);
        } catch (Exception e) {
            itemCountLabel.setText("Hiba: " + e.getMessage());
            e.printStackTrace();
        }
    }

    @FXML
    private Label itemCountLabel;

}
