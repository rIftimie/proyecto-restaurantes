import React, { useState } from "react";
import { changeStockProduct } from "../../helpers/kitchen";

const SelectProducts = ({ useStateProduct }) => {
  const [selectedProduct, setSelectedProduct] = useState(null);
  const [quantity, setQuantity] = useState(0);

  const handleConfirm = async (product, quantity) => {
    event.preventDefault();
    try {
      //   console.log(product, "Holaaaa soy la cantidad: " + quantity);
      await changeStockProduct(product, quantity); // actualiza el estado en el servidor
      useStateProduct.setProducts(
        useStateProduct.products.map((item) =>
          product.id == item.id ? { ...item, status: 2 } : item
        )
      ); // actualiza el estado en el cliente
    } catch (error) {
      console.error(error);
    }
  };

  const handleQuantityChange = (event) => {
    const newQuantity = event.target.value;
    setQuantity(newQuantity);
  };

  const handleProductChange = (event) => {
    setSelectedProduct(JSON.parse(event.target.value));
  };

  const handleIncreaseClick = () => {
    const newQuantity = quantity + 1;
    setQuantity(newQuantity);
  };

  const handleDecreaseClick = () => {
    const newQuantity = quantity - 1;
    setQuantity(newQuantity);
  };

  return (
    <form>
      <label htmlFor="product-select">Producto:</label>
      <select
        id="product-select"
        onChange={handleProductChange}
        value={selectedProduct ? JSON.stringify(selectedProduct) : ""}
        className="form-select"
      >
        {useStateProduct.products.map((product) => (
          <option
            className="text-center"
            key={product.product.id}
            value={JSON.stringify(product)}
          >
            {product.product.name}
          </option>
        ))}
      </select>
      {selectedProduct && (
        <div id="container">
          {/* {console.log(selectedProduct)} */}
          <label htmlFor="product-quantity">Cantidad:</label>
          <input
            className="text-center"
            type="number"
            id="product-quantity"
            value={quantity}
            onChange={handleQuantityChange}
          />

          <button type="button" onClick={handleIncreaseClick}>
            +
          </button>
          <button type="button" onClick={handleDecreaseClick}>
            -
          </button>
          <button onClick={() => handleConfirm(selectedProduct, quantity)}>
            Confirmar
          </button>
        </div>
      )}
    </form>
  );
};

export default SelectProducts;
