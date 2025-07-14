package org.example.invoiceappdesktop;

import javafx.fxml.FXML;
import javafx.scene.control.ListView;
import javafx.scene.control.TextField;
import javafx.stage.Stage;
import javafx.scene.control.Label;
import org.example.invoiceappdesktop.db.Database;
import org.example.invoiceappdesktop.db.ItemDAO;
import org.example.invoiceappdesktop.models.Item;

import java.math.BigDecimal;
import java.sql.SQLException;
import java.util.List;
import java.util.UUID;

public class TermekekViewController {
    private ItemDAO dao;

    @FXML
    private Label itemCountLabel;

    @FXML
    private ListView<Item> itemListView;

    @FXML
    private TextField nameField;

    @FXML
    private TextField priceField;

    private UUID itemId;

    @FXML
    public void initialize() {
        try {
            dao = new ItemDAO(Database.getConnection());

            int count = dao.getNumberOfItems();
            itemCountLabel.setText("Termékek száma: " + count);

            itemListView.getItems().setAll(dao.getAllItems());

            itemListView.getSelectionModel().selectedItemProperty().addListener((obs, oldItem, newItem) -> {
                if (newItem != null) {
                    nameField.setText(newItem.getName());
                    priceField.setText(newItem.getPrice().toPlainString());
                    itemId = newItem.getId();
                }
            });

        } catch (Exception e) {
            itemCountLabel.setText("Hiba: " + e.getMessage());
            e.printStackTrace();
        }
    }

    @FXML
    private void onAdd() {
        try {
            String name = nameField.getText();
            BigDecimal price = new BigDecimal(priceField.getText());

            if (name.length() > 0 && price.compareTo(BigDecimal.ZERO) > 0) {
                Item item = new Item(UUID.randomUUID(), name, price);
                dao.insertItem(item);
                Update();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void onUpdate() {
        try {
            if (itemId != null) {
                String name = nameField.getText();
                BigDecimal price = new BigDecimal(priceField.getText());

                if (name.length() > 0 && price.compareTo(BigDecimal.ZERO) > 0) {
                    Item updatedItem = new Item(itemId, name, price);
                    dao.updateItem(updatedItem);
                    Update();
                }
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    @FXML
    private void onDelete() {
        try {
            if (itemId != null) {
                dao.deleteItem(itemId);
                itemId = null;
                nameField.clear();
                priceField.clear();
                Update();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    private void Update() throws SQLException {
        List<Item> items = dao.getAllItems();
        itemListView.getItems().setAll(items);
    }
}
