// GET: Cobra un pedido en fisico: status 0 -> 1
export const payWaiter = async (order) => {
	try {
		const response = await fetch(
			`http://127.0.0.1:8000/orders/waiter/${order.id}/payWaiter`
		);
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.log(error);
	}
};

// GET: Entrega pedido al cliente: status 2 -> 3
export const deliver = async (order) => {
	try {
		const response = await fetch(
			`http://127.0.0.1:8000/orders/waiter/${order.id}/deliver`
		);
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.log(error);
	}
};
