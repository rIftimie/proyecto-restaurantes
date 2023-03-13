import React, { useEffect, useState } from "react";

const ProductsButtons = ({ idres , idtable , orderProducts , setOrderProducts , idprod, quantity , orderId, prods}) => {
  const [borrarVisible, setBorrarVisible] = useState(false);
  const [contador, setContador] = useState(0);
  useEffect(() => {
    if(quantity){
      setContador(quantity);
    }
    if(orderId){
      const newProds = prods.map(prod =>( {
        products_id: prod.product.id, 
        quantity : prod.product.quantity,
        name : prod.product.name,
        price : prod.product.price,
        allergens : prod.product.allergens,
        description : prod.product.description
      })
      )
      setOrderProducts(newProds);
    }
  }, [])  
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
      const prods2=[ ...orderProducts ];
      prods2.push(producto);
      setOrderProducts(prods2);
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
          className="btn btn-outline-success border m-1 ms-0"
          type="button"
          onClick={handleAgregarClick}
        >
          +
        </button>
      </div>
      <div style={{
            visibility: contador > 0 || borrarVisible ? "visible" : "hidden",
            
          }}>
              <button className="btn btn-outline-light m-1 border">{contador}</button>
            </div>
      <div>
        <button
          className="btn btn-outline-danger border m-1"
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
