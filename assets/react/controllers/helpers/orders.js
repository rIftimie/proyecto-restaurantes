const url = 'http://127.0.0.1:8000/api/orders';
const url2 = 'http://127.0.0.1:8000/orders';

// GET: Devuelve todos los pedidos de api/orders
export const getOrders = async () => {
	try {
		const response = await fetch(url);

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);
		const data = await response.json();
		console.log(data);
    return data;
	} catch (error) {
		console.log(error);
	}
};

// GET: Devuelve un pedido en especifico api/orders/{id}
export const getOrder = async (order) => {
	try {
		const response = await fetch(`${url}/${order.id}`);

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		const data = await response.json();
		return data;
	} catch (error) {
		console.log(error);
	}
};
// GET: Devuelve un pedido en especifico api/orders/{id} con la id
export const getOrderById = async (orderid) => {
	try {
		const response = await fetch(`${url}/${orderid}`);

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		const data = await response.json();
		return data;
	} catch (error) {
		console.log(error);
	}
};

// DELETE: Elimina un pedido
export const deleteOrder = async (order) => {
	try {
		const response = await fetch(`${url}/${order.id}`, {
			method: 'DELETE',
		});

		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return await response.json();
	} catch (error) {
		console.log(error);
	}
};
export const postOrder = async (data) => {
	try {
		const response = await fetch(url2+'/add', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json; charset=utf-8',
			},
			body: JSON.stringify(data),
		});
		if (!response.ok)
    throw new Error(response.status + ' ' + response.statusText);
    return response.json();
	} catch (error) {
		console.log(error);
	}
};

