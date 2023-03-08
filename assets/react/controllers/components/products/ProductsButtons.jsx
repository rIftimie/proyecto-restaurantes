import React, { useEffect, useState } from "react";

const ProductsButtons = ({ idres , idtable , orderProducts , setOrderProducts , idprod}) => {
  const [borrarVisible, setBorrarVisible] = useState(false);
  const [contador, setContador] = useState(0);
  
  const handleAgregarClick = () => {
    if (!borrarVisible) {
      setBorrarVisible(true);
    }
    setContador(contador + 1);
    if(orderProducts.filter((prod)=> prod.products_id==idprod)[0] ){
      const products = orderProducts.filter((prod)=> prod.products_id!=idprod);
      const newProduct = orderProducts.filter((prod)=> prod.products_id==idprod)[0];
      newProduct.quantity++;
      products.push(newProduct);
      setOrderProducts(products);
    }else{
      const producto={
        products_id : idprod,
        quantity:1,
        restaurant_id: idres,
        table_order_id: idtable
      }
      const prods=[ ...orderProducts ];
      prods.push(producto);
      setOrderProducts(prods);
    }
  };

  const handleQuitarClick = () => {
    if (contador > 0) {
      setContador(contador - 1);
    }
    if (contador === 1) {
      setBorrarVisible(false);
    }
    if(orderProducts.filter((prod)=> prod.products_id==idprod)[0] ){
      const products = orderProducts.filter((prod)=> prod.products_id!=idprod);
      const newProduct = orderProducts.filter((prod)=> prod.products_id==idprod)[0];
      newProduct.quantity--;
      if(newProduct.quantity!=0){
        products.push(newProduct);
      }
      setOrderProducts(products);
    }
  };

  const handleBorrarClick = () => {
    setContador(0);
    setBorrarVisible(false);
  };

  return (
    <div className="d-flex">
      <div>
        <button
          className="btn btn-outline-success m-1 ms-0"
          type="button"
          onClick={handleAgregarClick}
        >
          +
        </button>
      </div>
      <div style={{
            visibility: contador > 0 || borrarVisible ? "visible" : "hidden",
            
          }}>
              <button className="btn btn-outline-light m-1">{contador}</button>
            </div>
      <div>
        <button
          className="btn btn-outline-danger m-1"
          type="button"
          style={{
            visibility: contador > 0 || borrarVisible ? "visible" : "hidden",
            
          }}
          onClick={contador > 0 ? handleQuitarClick : handleBorrarClick}
        >
          {contador > 0 ? "-" : "-"}
        </button>
      </div>
    </div>
  );
};

export default ProductsButtons;
