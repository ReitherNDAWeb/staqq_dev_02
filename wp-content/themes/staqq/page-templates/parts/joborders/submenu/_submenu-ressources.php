<li class="current-item" data-tab="neu">Neu <span class="anzahl<?php if(count($joborders) == 0) echo ' anzahl--0'; ?>"><?php echo count($joborders); ?></span></li>
<li data-tab="gemerkt">Gemerkt <span class="anzahl<?php if(count($gemerkte) == 0) echo ' anzahl--0'; ?>"><?php echo count($gemerkte); ?></span></li>
<li data-tab="angenommen" class="tooltip-hover tooltip-bottom" title="Ich will diesen Job, warte auf Informationen vom Dienstleister">Angenommen <span class="anzahl<?php if(count($angenommen) == 0) echo ' anzahl--0'; ?>"><?php echo count($angenommen); ?></span></li>
<li data-tab="anderwaertig-vergeben">Anderwärtig vergeben/bestätigt <span class="anzahl<?php if(count($anderwaertig_vergeben) == 0) echo ' anzahl--0'; ?>"><?php echo count($anderwaertig_vergeben); ?></span></li>
<li data-tab="erhalten" class="tooltip-hover tooltip-bottom" title="Job wurde vom Dienstleister zugesagt, der tatsächliche Einsatz muss noch bestätigt werden">Bestätigt <span class="anzahl<?php if(count($erhalten) == 0) echo ' anzahl--0'; ?>"><?php echo count($erhalten); ?></span></li>
<li data-tab="erledigt">Erledigt <span class="anzahl<?php if(count($erledigt) == 0) echo ' anzahl--0'; ?>"><?php echo count($erledigt); ?></span></li>