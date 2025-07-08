package org.example.invoiceappdesktop.db;

import java.sql.*;
import java.util.*;
import java.math.BigDecimal;

import org.example.invoiceappdesktop.models.Item;

public class ItemDAO {

    private final Connection connection;

    public ItemDAO(Connection connection) {
        this.connection = connection;
    }

    public List<Item> getAllItems() throws SQLException {
        List<Item> items = new ArrayList<>();
        String query = "SELECT id, name, price FROM items ORDER BY name";

        try (Statement stmt = connection.createStatement();
             ResultSet rs = stmt.executeQuery(query)) {

            while (rs.next()) {
                Item item = new Item(
                        UUID.fromString(rs.getString("id")),
                        rs.getString("name"),
                        rs.getBigDecimal("price")
                );

                items.add(item);
            }
        }

        return items;
    }

    public void insertItem(Item item) throws SQLException {
        String query = "INSERT INTO items (id, name, price) VALUES (?, ?, ?)";

        try (PreparedStatement stmt = connection.prepareStatement(query)) {
            stmt.setString(1, item.getId().toString());
            stmt.setString(2, item.getName());
            stmt.setBigDecimal(3, item.getPrice());

            stmt.executeUpdate();
        }
    }

    public int getNumberOfItems() throws SQLException {
        String query = "SELECT COUNT(*) FROM items";

        try (PreparedStatement stmt = connection.prepareStatement(query);
             ResultSet rs = stmt.executeQuery()) {

            if (rs.next()) {
                return rs.getInt(1);
            }
        }

        return 0;
    }
}
