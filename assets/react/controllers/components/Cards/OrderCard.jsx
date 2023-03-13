import React from "react";
import classNames from "classnames";

function OrderCard({ order }) {
  

  const message = () => {
    if (order.status == 0) {
      return "Pago no realizado ";
    } else if (order.status == 1) {
      return "Pago realizado";
    } else if (order.status == 2) {
      return "Pedido realizado";
    } else if (order.status == 3) {
      return "Pedido completado";
    }
  };

  const confirmButton = () => {
    if (order.status == 1) {
      return (
        <form action="">
          <label htmlFor="">Mandar a cocina</label>
          <input type="button" value="Confirmar" />
        </form>
      );
    }
  }



    const listProducts = order.products;
    const productsNames = listProducts.map((product) => {
      return product.name;
    });

    return (
      <section
        className={classNames("card",  "d-flex",  " m-1",{
          "bg-red": order.status == 0,
          "bg-green": order.status == 1,
          "bg-black": order.status == 2,
          "bg-beige": order.status == 3,
        })}
      >
        <div className="card-body">
          <p>Camarero:{order.waiter}</p>
          <h6 className="card-title">Estado del pedido:{message()}</h6>
          <h6>Pedido realizado el:{order.orderDate.date}</h6>
          <h6>Producto:{productsNames}</h6>
          <h6>Pedido finalizado el:{order.deliverDate.date} </h6>
          <h6>Mesa:{order.tableNumber}</h6>
          {confirmButton()};
        </div>
      </section>
    );
  };
  


export default OrderCard;
