import React, { useState } from "react";

const ProductsButtons = () => {
  const [borrarVisible, setBorrarVisible] = useState(false);
  const [contador, setContador] = useState(0);

  const handleAgregarClick = () => {
    if (!borrarVisible) {
      setBorrarVisible(true);
    }
    setContador(contador + 1);
  };

  const handleQuitarClick = () => {
    if (contador > 0) {
      setContador(contador - 1);
    }
    if (contador === 1) {
      setBorrarVisible(false);
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
