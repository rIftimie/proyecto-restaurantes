const url = 'http://localhost:4000/tasks/';

export const getOrders = async () => {

    try {
        const response = await fetch(url);
        const data = await response.json();

        return data;
    } catch (error) {
        console.log(error);
    }
    
   
};

export const getOrder = async (order) => {
  
   try {
    const response = await fetch(`${url}/${order.id}`);
    const data = await response.json();
    return data;
   } catch (error) {
    console.log(error);
   }
   
  };

export const deleteOrder = async (order) => {
    try {
        
        const response = await fetch(`${url}/${order.id}`, {
        method: "DELETE",
        });

    
        return await response.json();
        
    } catch (error) {
        console.log(error);
    }

};

export const updateOrder = async (order) => {
    try {
    
        const response = await fetch(`${url}/${order.id}/edit`, {
        method: "PUT",
        headers: { "Content-Type": "application/json; charset=utf-8" },
        body: JSON.stringify(order),
        });

    
        return await response.json();
        
    } catch (error) {
        console.log(error);
    }
};
