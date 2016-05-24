SELECT m.msgId as Id, (Select if((select count(m1.msgId) from message as m1 where m1.msgParentId = m.msgId)=0, "non", "oui")) as Répondu, 
m.msgCreateTime as "Date", u1.userPseudo as Auteur, u2.userPseudo as Destinataire, m.msgSubject as Sujet
FROM message as m 
inner join user as u1 on m.msgAuthor=u1.userId 
inner join user as u2 on m.msgRecipient=u2.userId
where m.msgRecipient = 6