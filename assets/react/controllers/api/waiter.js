

export const paidWaiter = async (order) => {
  
    try {
     const response = await fetch(`http://127.0.0.1:8000/orders/${order.id}/paidWaiter`);
     console.log(response);
    
     const data = await response.json();
     return data;
    } catch (error) {
     console.log(error);
    }
    
   };

   export const delivered = async (order) => {
  
    try {
     const response = await fetch(`http://127.0.0.1:8000/orders/${order.id}/delivered`);
     console.log(response);
    
     const data = await response.json();
     return data;
    } catch (error) {
     console.log(error);
    }
    
   };