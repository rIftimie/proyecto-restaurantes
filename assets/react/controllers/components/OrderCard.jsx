import React from "react";
import { paidWaiter, delivered } from "../api/waiter";
import classNames from "classnames";

function OrderCard({order, onOrderStatusChange1, onOrderStatusChange2}) {

 

  const orderStatus = order.status;
  console.log(orderStatus);
  const classes = ["card text-light d-flex"];

  if (orderStatus == 0) {
    classes.push("bg-warning");
  }else if(orderStatus==1){
    classes.push("bg-success")
  }else if(orderStatus==2){
    classes.push("bg-danger")
  }else if(orderStatus==3){
    classes.push("bg-secondary")
  }else if(orderStatus==4){
    classes.push("bg-dark")
  }

  let status;
switch (order.status) {
  case 0:
    status = "Pendiente de pago";
    break;
  case 1:
    status = "pagado";
    break;
  case 2:
    status = "En proceso";
    break;
  case 3:
    status = "Listo";
    break;
  case 4:
    status = "Entregado";
    break;
  case 5:
    status = "Cancelado";
    break;
  default:
    status = "Estado desconocido";
    break;
}

  
  const handlePayCash1 = () => {
    paidWaiter(order);
    onOrderStatusChange1(order.id);
  }
  const handlePayCash2 = () => {
    delivered(order);
    onOrderStatusChange2(order.id);
  }

  // async function handleAccept(e){
  //   try {
  //     await acceptOrder(order);
  //     setOrder(orders.filter(od => od.id == order.id));
  //   } catch (error) {
  //     console.error(error);
  //   }
  // }
  function handleFinish(e){}
  function handleDecline(e){}

  return (
   
      <section className={classes.join(" ")}  style={{ textAlign: "center" }}>
        <div className="card-body">
          <p>Camarero:{order.waiter}</p>
          <h5 className="card-title">Estado del pedido:{status}</h5>
        
          {orderStatus == 0 && <button onClick={handlePayCash1}>Pagar en efectivo</button>}
          {orderStatus == 3 && <button onClick={handlePayCash2}>Entregar</button>}
        </div>
      </section>
   
  );
}

export default OrderCard;
