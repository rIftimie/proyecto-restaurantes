import React, { useEffect, useState } from 'react'
import CompletedCard from '../../components/Cards/CompletedCard';
import WaitingCard from '../../components/Cards/WaitingCard';

const ShowPage = ( { order } ) => {
  const [waiting, setWaiting] = useState(true);

  
  const showProducts=() =>{
    setWaiting(false);
  }
  
  useEffect(() => {
    if(order.status){
      showProducts();
    }
    const url = JSON.parse(document.getElementById('mercure-url').textContent);
		const eventSource = new EventSource(url);

		eventSource.onmessage = (event) => {
			// Will be called every time an update is published by the server
			if (JSON.parse(event.data).status == 1) {
				showProducts();
			}
		};
    
	}, []);

  return (
    <>
      {waiting && <WaitingCard orderId={ order.id } />}
      {!waiting && <CompletedCard order={ order } />}
    </>
  )
}

export default ShowPage