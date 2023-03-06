const url = 'http://127.0.0.1:8000/orders';

// PUT: Acepta un pedido: status 1 -> 2
export const acceptOrder = async (order) => {
	try {
		const response = await fetch(`${url}/kitchen/${order.id}/accept`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(order),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);
		return response;
	} catch (error) {
		console.log(error);
	}
};

// PUT: Termina un pedido: status 3 -> 4
export const finishOrder = async (order) => {
	try {
		const response = await fetch(`${url}/kitchen/${order.id}/finish`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(order),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};

// PUT: Cancela un pedido: status -> 5
export const declineOrder = async (order) => {
	try {
		const response = await fetch(`${url}/kitchen/${order.id}/decline`, {
			method: 'PUT',
			headers: { 'Content-Type': 'application/json; charset=utf-8' },
			body: JSON.stringify(order),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);

		return response;
	} catch (error) {
		console.error(error);
	}
};
