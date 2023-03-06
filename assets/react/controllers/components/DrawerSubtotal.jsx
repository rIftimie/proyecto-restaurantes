import React, { useState } from "react";
import Stripe from "./Stripe";
import '../../../styles/DrawerSubtotal.css'
function DrawerSubtotal({ isOpen, setIsDrawerOpen, stripeKey }) {
  const [stripe, setStripe] = useState(false);
  const [efectivo, setEfectivo] = useState(false);
  const handleCloseDrawer = () => {
    if (isOpen) {
      setIsDrawerOpen(false);
    }
  };

  const handleStripe = () => setStripe(!stripe);

  const handleEfectivo = () => setEfectivo(!efectivo);


  return (
    <div className={`drawer ${isOpen ? "open" : ""}`}>
      <div className=" d-flex flex-column col-8 mt-5 m-4">
        <div>
          <button onClick={handleStripe} type="button" class="btn btn-info fw-bold m-1">
            Pago con tarjeta
          </button>
          {stripe && <p className="fw-bold m-1"><Stripe stripeKey={ stripeKey } /></p>}
        </div>
        <div>
          <button
            onClick={handleEfectivo}
            type="button"
            class="btn btn-info fw-bold m-1"
          >
            Pago en efectivo
          </button>
          {efectivo && <p className="fw-bold m-1">Llame a un camarero para finalizar el pedido.</p>}
        </div>
      </div>
      <div>
        <button
          onClick={handleCloseDrawer}
          type="button"
          className="btn btn-outline-dark fw-bold m-3"
        >
          <i class="fa-light fa-xmark"></i>
        </button>
      </div>
    </div>
  );
}

export default DrawerSubtotal;
