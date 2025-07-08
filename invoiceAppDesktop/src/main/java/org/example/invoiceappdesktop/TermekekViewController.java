package org.example.invoiceappdesktop;

import javafx.fxml.FXML;
import javafx.scene.control.ListView;
import javafx.stage.Stage;
import javafx.scene.control.Label;
import org.example.invoiceappdesktop.db.Database;
import org.example.invoiceappdesktop.db.ItemDAO;
import org.example.invoiceappdesktop.models.Item;

import java.util.List;

public class TermekekViewController {

    @FXML
    public void initialize() {
        try {
            ItemDAO dao = new ItemDAO(Database.getConnection());

            int count = dao.getNumberOfItems();
            itemCountLabel.setText("Termékek száma: " + count);

            itemListView.getItems().setAll(dao.getAllItems());

        } catch (Exception e) {
            itemCountLabel.setText("Hiba: " + e.getMessage());
            e.printStackTrace();
        }
    }

    @FXML
    private Label itemCountLabel;

    @FXML
    private ListView<Item> itemListView;
}
