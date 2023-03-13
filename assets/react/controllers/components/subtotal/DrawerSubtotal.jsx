import React, { useState } from "react";
import Stripe from "../stripe/Stripe";
import "../../../../styles/DrawerSubtotal.css";

function DrawerSubtotal({ isOpen, setIsDrawerOpen, stripeKey, orderId , orderProducts}) {
  const [stripe, setStripe] = useState(false);

  const handleCloseDrawer = () => {
    if (isOpen) {
      setIsDrawerOpen(false);
    }
  };

  const handleStripe = () => setStripe(!stripe);

  return (
    <div className={`drawer ${isOpen ? "open" : ""}`}>
      <div className="d-flex flex-column col-8 mt-5 m-4">
        <div className="container-fluid">
          <button
            onClick={handleStripe}
            type="button"
            className="btn btn-info fw-bold m-1"
          >
            Pago con tarjeta
          </button>
          {stripe && (
            <p className="fw-bold m-1">
              <Stripe orderId={orderId} orderProducts={orderProducts} stripeKey={stripeKey} />
            </p>
          )}
        </div>
        <div className="container-lg">
          <button
            onClick={handleStripe}
            type="button"
            className="btn btn-info fw-bold m-1"
          >
            Pago en efectivo
          </button>
        </div>
      </div>
      <div className="col align-self-start justify-content-center">
        <button
          onClick={handleCloseDrawer}
          type="button"
          className="btn btn-outline-dark fw-bold m-4"
        >
          <i className="far fa-times-circle"></i>
        </button>
      </div>
    </div>
  );
}

export default DrawerSubtotal;
