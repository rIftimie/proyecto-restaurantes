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
      <div className=" d-flex flex-column col-8 mt-5">
        <Stripe></Stripe>
        <p>Pago con tarjeta</p>
        <p>Pago en efectivo</p>
        <p>Paypal</p>
      </div>
      <div className='col-4'>
        <button
          onClick={handleCloseDrawer}
          type="button"
          className="btn btn-outline-danger m-3"
        >Cerrar</button>
      </div>
    </div>
  );
}

export default DrawerSubtotal;
