import React, { useState } from "react";
import './adminPage.css';
import Prueba from "../../components/Prueba";
import User from "../../components/User";
import Product from "../../components/Product";
import Order from "../../components/Order";
import Table from "../../components/Table";

const components = {
  Prueba: <Prueba />,
  User: <User />,
  Product: <Product />,
  Order: <Order />,
  Table: <Table />,
};

const AdminPages = () => {
  const [selectedItem, setSelectedItem] = useState('Prueba');

  const handleClick = (name) => {
    setSelectedItem(name);
  };

  return (
    <div className="admin-container">
      <h1 className="admin-title">Admin panel</h1>
      <nav className="admin-nav">
        <ul>
          <li className="elemento-menu" onClick={() => handleClick('User')}>User</li>
          <li className="elemento-menu" onClick={() => handleClick('Product')}>Product</li>
          <li className="elemento-menu" onClick={() => handleClick('Order')}>Order</li>
          <li className="elemento-menu" onClick={() => handleClick('Table')}>Table</li>
        </ul>
      </nav>
      <div className="admin-content">{components[selectedItem]}</div>
    </div>
  );
}

export default AdminPages;
