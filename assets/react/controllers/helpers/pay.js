const url = 'http://127.0.0.1:8000/orders/';
export const payOrder2 = async (orderId, data) => {
	try {
		const response = await fetch(url+orderId+'/pay', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json; charset=utf-8',
			},
			body: JSON.stringify(data),
		});
		if (!response.ok)
			throw new Error(response.status + ' ' + response.statusText);
		return response;
	} catch (error) {
		console.log(error);
	}
};
