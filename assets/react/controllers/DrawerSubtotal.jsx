import React from 'react'
import Stripe from './Stripe'

function DrawerSubtotal({ isOpen, setIsDrawerOpen }) {
  const handleCloseDrawer = () => {
    if (isOpen) {
      setIsDrawerOpen(false);
    }
  };
  return (
    <div className={`drawer ${isOpen ? "open" : ""}`}>
      <div className=" d-flex justify-content-center flex-colum flex-wrap">
        <p>Pago con tarjeta</p>
        <p>Pago en efectivo</p>
        <p>Paypal</p>
      </div>
      <button
        onClick={handleCloseDrawer}
        type="button"
        className="btn btn-outline-danger m-3"
      >Cerrar</button>
    </div>
  );
}

export default DrawerSubtotal;
