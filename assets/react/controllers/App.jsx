import React from 'react';
import AdminPages from '../pages/admin/AdminPages';

function App({fullName}) {
	return( 
		<div>
			{/* <h1>Admin Panel</h1> */}
			<AdminPages></AdminPages>
			<WaiterPage/>
		</div>
	)
}

export default App