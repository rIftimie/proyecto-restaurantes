const waiterUrl = 'http://127.0.0.1:8000/orders/waiter';

// GET: Cobra un pedido en fisico: status 0 -> 1
export const payWaiter = async (order, user) => {
	try {
		const response = await fetch(`${waiterUrl}/${order.id}/payWaiter`, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(user.id),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.log(error);
	}
};

// GET: Entrega pedido al cliente: status 2 -> 3
export const deliver = async (order, user) => {
	try {
		const response = await fetch(`${waiterUrl}/${order.id}/deliver`, {
			method: 'POST',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(user.id),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.log(error);
	}
};
